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
    public function indexAction(Request $request, Application $app)
    {
        $vagrant = new VagrantBundle($this->get('ansible.path'));
        $name    = $request->get('vmname');

        $boxName = $request->get('baseBox') ?: 'precise64';
        $box     = $this->getBox($boxName);

        $webServerKey = $request->get('webserver') ?: 'nginxphp';
        $webserver    = $this->getWebServer($webServerKey);

        /** Create the Renderers */
        $vagrantfile = new VagrantfileRenderer();
        $inventory   = new TemplateRenderer();
        $playbook    = new PlaybookRenderer();
        $common      = new VarfileRenderer('common');

        /** Set the Inventory */
        $inventory->add('ipAddress', $request->get('ipaddress'));
        $inventory->setTemplate('inventory.twig');
        $inventory->setFilePath('ansible/inventories/dev');

        /** Configure Vagrantfile */
        $vagrantfile->setName($name);
        $vagrantfile->setBoxName($boxName);
        $vagrantfile->setBoxUrl($box['url']);
        $vagrantfile->setMemory($request->get('memory'));
        $vagrantfile->setIpAddress($request->get('ipaddress'));
        $vagrantfile->setSyncedFolder($request->get('sharedfolder'));

        /** Configure Variable files - common */
        $common->add('php_ppa', $request->get('phpppa'));
        $common->add('doc_root', $request->get('docroot'));
        $common->add('sys_packages', $request->get('syspackages', array()));
        $common->add('timezone', $request->get('timezone'));

        /** Configure Playbook */
        $playbook->addVar('web_server', $webServerKey);
        $playbook->addRole('init');

        $php_packages = $request->get('phppackages', array());

        /** Databases */
        if ($request->get('database-status')) {
            $playbook->addRole('mysql');

            $mysqlvars = new VarfileRenderer('mysql');
            $mysqlvars->setTemplate('roles/mysql.vars.twig');

            $mysqlvars->setData([ 'mysql_vars' => [
                    [
                        'user' => $request->get('user'),
                        'pass' => $request->get('password'),
                        'db'   => $request->get('database'),
                    ]
                ]]);

            $vagrant->addRenderer($mysqlvars);
            $playbook->addVarsFile('vars/mysql.yml');
            $php_packages[] = 'php5-mysql';
        }

        if ($request->get('xdebug')) {
            $php_packages[] = 'php5-xdebug';
        }

        $common->add('php_packages', array_unique($php_packages));

        foreach ($webserver['include'] as $role) {
            $playbook->addRole($role);
        }

        if ($request->get('composer')) {
            $playbook->addRole('composer');
        }

        $playbook->addRole('phpcommon');
        $playbook->addVarsFile('vars/common.yml');

        $vagrant->addRenderer($playbook);
        $vagrant->addRenderer($common);
        $vagrant->addRenderer($vagrantfile);
        $vagrant->addRenderer($inventory);

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($vagrant->generateBundle($zipPath, $playbook->getRoles())) {

            return $this->outputBundle($zipPath, $app, $name);

        } else {

            return new Response('An error occurred.');
        }
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
        $boxes = $this->get('config')['boxes'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }

    /**
     * @param string $webServerKey
     * @return array
     */
    public function getWebServer($webServerKey)
    {
        $webservers   = $this->get('config')['webservers'];
        $webServerKey = array_key_exists($webServerKey, $webservers) ? $webServerKey : 'nginxphp';

        return $webservers[$webServerKey];
    }
}
