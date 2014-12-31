<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Phansible\Application;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\TemplateRenderer;
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
        $requestVars = $request->request->all();
        $requestVars['server']['locale'] = $this->extractLocale(
            $request->getLanguages()
        );

        $inventory = $this->getInventory($requestVars);
        $varsFile = new VarfileRenderer('all');

        $playbook = new PlaybookRenderer();
        // @todo fix str_replace
        $playbook->setVarsFilename(str_replace('ansible/', '', $varsFile->getFilePath()));

        $vagrantBundle = new VagrantBundle(
            $this->get('ansible.path')
        );

        $vagrantBundle->setPlaybook($playbook)
          ->setVarsFile($varsFile)
          ->setInventory($inventory);

        $app['roles']->setupRole($requestVars, $vagrantBundle);
        $playbook->addRole('app');

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
     * @param array $requestVars
     * @return TemplateRenderer
     * @todo: this needs some refactoring when we have more deployment methods
     */
    protected function getInventory(array $requestVars)
    {
        $ipAddress = $requestVars['vagrant_local']['vm']['ip'];
        $inventory = new TemplateRenderer();
        $inventory->add('ipAddress', $ipAddress);
        $inventory->setTemplate('inventory.twig');
        $inventory->setFilePath('ansible/inventories/dev');

        return $inventory;
    }

    public function extractLocale($languages)
    {
        $locale = 'en_US';

        if (is_array($languages)) {
            foreach ($languages as $language) {
                if (preg_match('/[a-z]_[A-Z]/', $language)) {
                    $locale = $language;
                    break;
                }
            }
        }

        $locale .= '.UTF-8';

        return $locale;
    }

    /**
     * @param string $zipPath
     * @param Application $app
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function outputBundle($zipPath, Application $app, $filename)
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
