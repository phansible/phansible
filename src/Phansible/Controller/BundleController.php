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
    public function indexAction(Request $request, Application $app)
    {
        $requestVars = $request->request->all();

        $inventory = $this->getInventory($request);
        $varsFile = new VarfileRenderer('all');

        $playbook = new PlaybookRenderer();
        // @todo fix str_replace
        $playbook->setVarsFilename(str_replace('ansible/', '', $varsFile->getFilePath()));
        $playbook->addRole('app');

        $vagrantBundle = new VagrantBundle(
          $this->get('ansible.path')
        );

        $vagrantBundle->setPlaybook($playbook)
          ->setVarsFile($varsFile)
          ->setInventory($inventory);

        $app['roles']->setupRole($requestVars, $vagrantBundle);

        $tmpName = 'bundle_' . time();
        $zipPath = sys_get_temp_dir() . "/$tmpName.zip";

        if ($vagrantBundle->generateBundle(
          $zipPath,
          $playbook->getRoles()
        )
        ) {
            $vagrantfile = $vagrantBundle->getVagrantFile();
            return $this->outputBundle($zipPath, $app, $vagrantfile->getName());
        }

        return new Response('An error occurred.');
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

}
