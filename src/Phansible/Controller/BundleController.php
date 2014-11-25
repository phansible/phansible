<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Phansible\Application;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\TemplateRenderer;
use Phansible\Renderer\VagrantfileRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Phansible
 */
class BundleController extends Controller
{
    protected $phpPackages = [];

    /**
     * @var array
     */
    private $peclPackages = [];

    /**
     * @var Phansible\Model\VagrantBundle
     */
    private $vagrantBundle;

    public function indexAction(Request $request, Application $app)
    {
        $this->setPhpPackages($request->get('phppackages', array()));

        $this->setPeclPackages($request->get('peclpackages', []));

        /** Get Inventory */
        $inventory = $this->getInventory($request);

        /** Get Vagrantfile */
        $vagrantfile = $this->getVagrantfile($request);

        /** Get Playbook */
        $playbook = $this->getPlaybook($request);

        $this->setupDatabase($playbook, $request);
        $this->setupComposer($playbook, $request);
        $this->setupXDebug($playbook, $request);

        /** Configure Variable files - common */
        $box = $this->getBox($vagrantfile->getBoxName());

        $playbook->createVarsFile('common', [
                'php_ppa'       => $request->get('phpppa'),
                'doc_root'      => $request->get('docroot'),
                'sys_packages'  => $request->get('syspackages', array()),
                'dist'          => $box['deb'],
                'php_packages'  => $this->getPhpPackages(),
                'pecl_packages' => $this->getPeclPackages()
        ]);

        $playbook->addRole('phpcommon');

        if ($this->getPeclPackages()) {
            $playbook->addRole('php-pecl');
        }

        $playbook->addRole('app');

        $this->getVagrantBundle()
            ->setRenderers($playbook->getVarsFiles())
            ->addRenderer($playbook)
            ->addRenderer($vagrantfile)
            ->addRenderer($inventory);

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($this->getVagrantBundle()->generateBundle($zipPath, $playbook->getRoles())) {
            return $this->outputBundle($zipPath, $app, $vagrantfile->getName());
        }

        return new Response('An error occurred.');
    }

    /**
     * @param PlaybookRenderer $playbook
     * @param Request $request
     */
    public function setupDatabase(PlaybookRenderer $playbook, Request $request)
    {
        /** Databases */
        $dbserver  = $request->get('dbserver');
        if (! $dbserver) {
            // No DB-Server wanted
            return;
        }

        $dbservers = $this->get('databases');
        if (! array_key_exists($dbserver, $dbservers)) {

            // DB-Server wanted that we do not provide.
            return;
        }

        $playbook->addRole($dbserver);

        // Enable php-mysql package when user selected mysql as db provider
        if ($dbserver === 'mysql') {
            $this->addPhpPackage('php5-mysql');
        }

        $dbVars = new VarfileRenderer($dbserver);
        $dbVars->add('db_vars', [
            [
                'user' => $request->get('user'),
                'pass' => $request->get('password'),
                'db'   => $request->get('database'),
            ]
        ], false);

        $dbVars->setTemplate('roles/db.vars.twig');
        $playbook->addVarsFile($dbVars);
    }

    /**
     * @param PlaybookRenderer $playbook
     * @param Request $request
     */
    public function setupComposer(PlaybookRenderer $playbook, Request $request)
    {
        if ($request->get('composer')) {
            $playbook->addRole('composer');
        }
    }

    /**
     * @param PlaybookRenderer $playbook
     * @param Request $request
     */
    public function setupXDebug(PlaybookRenderer $playbook, Request $request)
    {
        if ($request->get('xdebug')) {
            $this->addPhpPackage('php5-xdebug');
        }
    }

    /**
     * @param Request $request
     * @return VagrantfileRenderer
     */
    public function getVagrantfile(Request $request)
    {
        $name = $request->get('vmname');
        $boxName = $request->get('baseBox') ?: 'precise64';
        $box = $this->getBox($boxName);

        $vagrantfile = new VagrantfileRenderer();
        $vagrantfile->setName($name);
        $vagrantfile->setBoxName($box['cloud']);
        $vagrantfile->setMemory($request->get('memory'));
        $vagrantfile->setIpAddress($request->get('ipAddress'));
        $vagrantfile->setSyncedFolder($request->get('sharedFolder'));
        $vagrantfile->setEnableWindows($request->get('enableWindows'));
        $vagrantfile->setSyncedType($request->get('syncType'));

        if (!$request->get('useVagrantCloud')) {
            $vagrantfile->setBoxUrl($box['url']);
        }

        return $vagrantfile;
    }

    /**
     * @param Request $request
     * @return TemplateRenderer
     */
    public function getInventory(Request $request)
    {
        $inventory = new TemplateRenderer();
        $inventory->add('ipAddress', $request->get('ipAddress'));
        $inventory->setTemplate('inventory.twig');
        $inventory->setFilePath('ansible/inventories/dev');

        return $inventory;
    }

    /**
     * @param Request $request
     * @return PlaybookRenderer
     */
    public function getPlaybook(Request $request)
    {
        $webServerKey = $request->get('webserver') ?: 'nginxphp';
        $webserver    = $this->getWebServer($webServerKey);

        $playbook = new PlaybookRenderer();
        $playbook->addVar('web_server', $webServerKey);
        $playbook->addVar('servername', trim($request->get('servername')) . ' ' . $request->get('ipAddress'));
        $playbook->addRole('init');
        $playbook->addRole('php5-cli');
        $playbook->addVar('timezone', $request->get('timezone'));

        foreach ($webserver['include'] as $role) {
            $playbook->addRole($role);
        }

        return $playbook;
    }

    /**
     * @param string $package
     */
    public function addPhpPackage($package)
    {
        $this->phpPackages[] = $package;
    }

    /**
     * @param array $packages
     */
    public function setPhpPackages(array $packages)
    {
        $this->phpPackages = $packages;
    }

    /**
     * @return array
     */
    public function getPhpPackages()
    {
        return array_unique($this->phpPackages);
    }

    /**
     * @param string $zipPath
     * @param Application $app
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function outputBundle($zipPath, Application $app, $filename)
    {
        $stream = function () use ($zipPath) {
            readfile($zipPath);
        };

        return $app->stream($stream, 200, array(
            'Content-length'      => filesize($zipPath),
            'Content-Disposition' => 'attachment; filename="phansible_' . $filename . '.zip"',
            'Content-Type'        => 'application/zip'
        ));
    }

    /**
     * @param string $boxName
     * @return string
     */
    public function getBox($boxName)
    {
        $boxes = $this->get('boxes')['virtualbox'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }

    /**
     * @param string $webServerKey
     * @return array
     */
    public function getWebServer($webServerKey)
    {
        $webservers   = $this->get('webservers');
        $webServerKey = array_key_exists($webServerKey, $webservers) ? $webServerKey : 'nginxphp';

        return $webservers[$webServerKey];
    }

    public function getPeclPackages()
    {
        return array_unique($this->peclPackages);
    }

    public function setPeclPackages(array $packages)
    {
        $this->peclPackages = $packages;

        return $this;
    }

    public function getVagrantBundle()
    {
        if (null === $this->vagrantBundle) {
            $this->vagrantBundle = new VagrantBundle($this->get('ansible.path'));
        }

        return $this->vagrantBundle;
    }

    public function setVagrantBundle(VagrantBundle $vagrantBundle)
    {
        $this->vagrantBundle = $vagrantBundle;

        return $this;
    }
}
