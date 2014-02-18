<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Phansible\Application;
use Phansible\Model\VagrantBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Skeleton
 */
class BundleController extends Controller
{

    public function indexAction(Request $request, Application $app)
    {
        $vagrant = new VagrantBundle();
        $name = $request->get('vmname');
        $boxes = $this->get('config')['boxes'];

        $boxName = array_key_exists($request->get('baseBox'), $boxes) ? $request->get('baseBox') : 'precise64';
        $box =  $boxes[$boxName];

        /** Machine Options */
        $vagrant->setVmName($name);
        $vagrant->setMemory($request->get('memory'));
        $vagrant->setBox($boxName);
        $vagrant->setBoxUrl($box['url']);
        $vagrant->setIpAddress($request->get('ipaddress'));
        $vagrant->setSyncedFolder($request->get('sharedfolder'));

        /** Provision Options */
        $vagrant->setWebserver($request->get('webserver'));
        $vagrant->setPhpPPA($request->get('phpppa'));
        $vagrant->setDocRoot($request->get('docroot'));
        $vagrant->setSyspackages($request->get('syspackages'));
        $vagrant->setPhpPackages($request->get('phppackages'));
        $vagrant->setInstallComposer($request->get('composer'));

        $tmpName = 'bundle_' . time();
        $zipPath = __DIR__ . "/../../../app/data/$tmpName.zip";

        if ($vagrant->generateBundle($zipPath)) {

            $stream = function () use ($zipPath) {
                readfile($zipPath);
            };

            return $app->stream($stream, 200, array(
                'Content-length' => filesize($zipPath),
                'Content-Disposition' => 'attachment; filename="phansible_' . $name . '.zip"'
            ));


        } else {
            return new Response('An error ocurred.');
        }

        //return $this->render('index.html.twig');
    }
}
