<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Phansible\Application;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\TemplateRenderer;
use Phansible\Renderer\VagrantfileRenderer;
use Phansible\Renderer\VarfileRenderer;
use Phansible\RoleManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Phansible
 */
class BundleController extends Controller
{
    /**
     * @var \Phansible\Model\VagrantBundle
     */
    private $vagrantBundle;

    public function indexAction(Request $request, Application $app)
    {
        $requestVars = $request->request->all();

        /** Get Inventory */
        $inventory = $this->getInventory($request);

        /** Get Vagrantfile */
        $vagrantfile = $this->getVagrantfile($requestVars);

        /** Get Playbook */
        $playbook = $this->getPlaybook($request);

        $varsFile = new VarfileRenderer('all');

        $app['roles']->setupRole($requestVars, $playbook, $varsFile);

        $playbook->addVarsFile($varsFile);
        $playbook->addRole('app');

        $this->getVagrantBundle()
          ->setRenderers($playbook->getVarsFiles())
          ->addRenderer($playbook)
          ->addRenderer($vagrantfile)
          ->addRenderer($inventory);

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($this->getVagrantBundle()->generateBundle(
          $zipPath,
          $playbook->getRoles()
        )
        ) {
            return $this->outputBundle($zipPath, $app, $vagrantfile->getName());
        }

        return new Response('An error occurred.');
    }

    /**
     * @param array $requestVars
     * @return VagrantfileRenderer
     */
    public function getVagrantfile(array $requestVars)
    {
        $config = $requestVars['vagrantfile-local'];
        $name = $config['vm']['name'];
        $boxName = $config['vm']['box_url'];
        // $boxName = $request->get('baseBox') ?: 'precise64';
        $box = $this->getBox($boxName);

        $vagrantfile = new VagrantfileRenderer();
        $vagrantfile->setName($name);
        $vagrantfile->setBoxName($box['cloud']);
        $vagrantfile->setMemory($config['vm']['memory']);
        $vagrantfile->setIpAddress($config['vm']['ip']);
        $vagrantfile->setSyncedFolder($config['vm']['sharedfolder']);
        $vagrantfile->setEnableWindows($config['vm']['enableWindows']);
        $vagrantfile->setSyncedType($config['vm']['syncType']);

        ///if (!$request->get('useVagrantCloud')) {
        //     $vagrantfile->setBoxUrl($box['url']);
        //}

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
        $webserver = $this->getWebServer($webServerKey);

        $playbook = new PlaybookRenderer();
        $playbook->addVar('web_server', $webServerKey);
        $playbook->addVar(
          'servername',
          trim($request->get('servername')) . ' ' . $request->get('ipAddress')
        );
        $playbook->addRole('init');
        $playbook->addRole('php5-cli');
        $playbook->addVar('timezone', $request->get('timezone'));

        foreach ($webserver['include'] as $role) {
            $playbook->addRole($role);
        }

        return $playbook;
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

        return $app->stream(
          $stream,
          200,
          array(
            'Content-length' => filesize($zipPath),
            'Content-Disposition' => 'attachment; filename="phansible_' . $filename . '.zip"',
            'Content-Type' => 'application/zip'
          )
        );
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
        $webservers = $this->get('webservers');
        $webServerKey = array_key_exists(
          $webServerKey,
          $webservers
        ) ? $webServerKey : 'nginxphp';

        return $webservers[$webServerKey];
    }

    public function getVagrantBundle()
    {
        if (null === $this->vagrantBundle) {
            $this->vagrantBundle = new VagrantBundle(
              $this->get('ansible.path')
            );
        }

        return $this->vagrantBundle;
    }

    public function setVagrantBundle(VagrantBundle $vagrantBundle)
    {
        $this->vagrantBundle = $vagrantBundle;

        return $this;
    }
}
