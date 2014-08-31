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

    public function indexAction(Request $request, Application $app)
    {
        $vagrant = new VagrantBundle($this->get('ansible.path'));
        $this->setPhpPackages($request->get('phppackages', array()));

        /** Get Inventory */
        $inventory = $this->getInventory($request);

        /** Get Vagrantfile */
        $vagrantfile = $this->getVagrantfile($request);

        /** Get Playbook */
        $playbook = $this->getPlaybook($request);

        $this->setupMysql($playbook, $request);
        $this->setupComposer($playbook, $request);
        $this->setupXDebug($playbook, $request);

        /** Configure Variable files - common */
        $box = $this->getBox($vagrantfile->getBoxName());

        $playbook->createVarsFile('common', [
                'php_ppa'      => $request->get('phpppa'),
                'doc_root'     => $request->get('docroot'),
                'sys_packages' => $request->get('syspackages', array()),
                'timezone'     => $request->get('timezone'),
                'dist'         => $box['deb'],
                'php_packages' => $this->getPhpPackages()
        ]);

        $playbook->addRole('phpcommon');

        $vagrant->setRenderers($playbook->getVarsFiles());
        $vagrant->addRenderer($playbook);
        $vagrant->addRenderer($vagrantfile);
        $vagrant->addRenderer($inventory);

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($vagrant->generateBundle($zipPath, $playbook->getRoles())) {

            return $this->outputBundle($zipPath, $app, $vagrantfile->getName());

        } else {

            return new Response('An error occurred.');
        }
    }

    /**
     * @param PlaybookRenderer $playbook
     * @param Request $request
     */
    public function setupMysql(PlaybookRenderer $playbook, Request $request)
    {
        /** Databases */
        if ($request->get('database-status')) {
            $playbook->addRole('mysql');

            $mysqlVars = new VarfileRenderer('mysql');
            $mysqlVars->add('mysql_vars', [
                [
                    'user' => $request->get('user'),
                    'pass' => $request->get('password'),
                    'db'   => $request->get('database'),
                ]
            ], false);

            $mysqlVars->setTemplate('roles/mysql.vars.twig');
            $playbook->addVarsFile($mysqlVars);

            $this->addPhpPackage('php5-mysql');
        }
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
        $vagrantfile->setBoxName($boxName);
        $vagrantfile->setBoxUrl($box['url']);
        $vagrantfile->setMemory($request->get('memory'));
        $vagrantfile->setIpAddress($request->get('ipaddress'));
        $vagrantfile->setSyncedFolder($request->get('sharedfolder'));
        $vagrantfile->setEnableWindows($request->get('enable-windows'));
        $vagrantfile->setSyncedType($request->get('sync-type'));

        return $vagrantfile;
    }

    /**
     * @param Request $request
     * @return TemplateRenderer
     */
    public function getInventory(Request $request)
    {
        $inventory = new TemplateRenderer();
        $inventory->add('ipAddress', $request->get('ipaddress'));
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
        $playbook->addRole('init');

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
            'Content-length' => filesize($zipPath),
            'Content-Disposition' => 'attachment; filename="phansible_' . $filename . '.zip"'
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
}
