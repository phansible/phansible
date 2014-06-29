<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Phansible\Application;
use Phansible\Model\VagrantBundle;
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
        $name = $request->get('vmname');

        /** Get box options from config */
        $boxes   = $this->get('config')['boxes'];
        $boxName = array_key_exists($request->get('baseBox'), $boxes) ? $request->get('baseBox') : 'precise64';
        $box     =  $boxes[$boxName];

        /** Get web server options from config */
        $webservers   = $this->get('config')['webservers'];
        $webServerKey = array_key_exists($request->get('webserver'), $webservers) ? $request->get('webserver') : 'nginxphp';
        $webserver    = $webservers[$webServerKey];

        /** Set Machine Options */
        $vagrant->setVmName($name);
        $vagrant->setMemory($request->get('memory'));
        $vagrant->setBox($boxName);
        $vagrant->setBoxUrl($box['url']);
        $vagrant->setIpAddress($request->get('ipaddress'));
        $vagrant->setSyncedFolder($request->get('sharedfolder'));

        /** Set Playbook Vars */
        $vagrant->setPhpPPA($request->get('phpppa'));
        $vagrant->setDocRoot($request->get('docroot'));
        $vagrant->setSyspackages($request->get('syspackages'));

        /** Set PHP Packages */
        $vagrant->setPhpPackages($request->get('phppackages', array()));

        if ($request->get('xdebug')) {
            $vagrant->addPhpPackage('php5-xdebug');
        }

        /** Add Roles */
        $vagrant->addRole('init');

        foreach ($webserver['include'] as $role) {
            $vagrant->addRole($role);
        }

        if ($request->get('composer')) {
            $vagrant->addRole('composer');
        }

        $vagrant->addRole('phpcommon');

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($vagrant->generateBundle($zipPath)) {

            $stream = function () use ($zipPath) {
                readfile($zipPath);
            };

            return $app->stream($stream, 200, array(
                'Content-length' => filesize($zipPath),
                'Content-Disposition' => 'attachment; filename="phansible_' . $name . '.zip"'
            ));

        } else {
            return new Response('An error occurred.');
        }

    }
}
