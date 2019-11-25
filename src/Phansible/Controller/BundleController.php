<?php

namespace App\Phansible\Controller;

use App\Phansible\Application;
use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\PlaybookRenderer;
use App\Phansible\Renderer\TemplateRenderer;
use App\Phansible\Renderer\VarfileRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * @package Phansible
 */
class BundleController
{
    /**
     * @var VagrantBundle
     */
    private $vagrantBundle;

    /**
     * @param Request $request
     * @param Application $app
     * @return Response
     */
    public function indexAction(Request $request, Application $app): Response
    {
        $requestVars                     = $request->request->all();
        $requestVars['server']['locale'] = $this->extractLocale(
            $request->getLanguages()
        );

        $inventory = $this->getInventory($requestVars);
        $varsFile  = new VarfileRenderer('all');

        $playbook = new PlaybookRenderer();
        // @todo fix str_replace
        $playbook->setVarsFilename(str_replace('ansible/', '', $varsFile->getFilePath()));

        $this->getVagrantBundle()
            ->setPlaybook($playbook)
            ->setVarsFile($varsFile)
            ->setInventory($inventory);

        $app['roles']->setupRole($requestVars, $this->getVagrantBundle());
        $playbook->addRole('app');

        $zipPath = tempnam(sys_get_temp_dir(), 'phansible_bundle_');

        if ($this->getVagrantBundle()->generateBundle(
            $zipPath,
            $playbook->getRoles()
        )
        ) {
            $vagrantfile = $this->getVagrantBundle()->getVagrantFile();

            return $this->outputBundle($zipPath, $app, $vagrantfile->getName());
        }

        return new Response('An error occurred.');
    }

    /**
     * @param $languages
     * @return mixed|string
     */
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
     * @param array $requestVars
     * @return TemplateRenderer
     * @todo: this needs some refactoring when we have more deployment methods
     */
    private function getInventory(array $requestVars): TemplateRenderer
    {
        $ipAddress = $requestVars['vagrant_local']['vm']['ip'];
        $inventory = new TemplateRenderer();
        $inventory->add('ipAddress', $ipAddress);
        $inventory->setTemplate('inventory.twig');
        $inventory->setFilePath('ansible/inventories/dev');

        return $inventory;
    }

    /**
     * @return VagrantBundle
     */
    private function getVagrantBundle(): VagrantBundle
    {
        if (!$this->vagrantBundle instanceof VagrantBundle) {
            $twig = new Twig_Environment(
                new Twig_Loader_Filesystem($this->get('ansible.templates'))
            );

            $this->vagrantBundle = new VagrantBundle(
                $this->get('ansible.path'),
                $twig
            );
        }

        return $this->vagrantBundle;
    }

    /**
     * @param string $zipPath
     * @param Application $app
     * @param string $filename
     * @return StreamedResponse
     */
    private function outputBundle($zipPath, Application $app, $filename): StreamedResponse
    {
        $stream = static function () use ($zipPath) {
            echo file_get_contents($zipPath);
            unlink($zipPath);
        };

        $response = $app->stream(
            $stream,
            Response::HTTP_OK,
            array(
                'Content-length' => filesize($zipPath),
                'Content-Type'   => 'application/zip',
                'Pragma'         => 'no-cache',
                'Cache-Control'  => 'no-cache',
            )
        );

        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'phansible_' . $filename . '.zip'
        ));

        return $response;
    }

    /**
     * @param VagrantBundle $vagrantBundle
     */
    public function setVagrantBundle(VagrantBundle $vagrantBundle): void
    {
        $this->vagrantBundle = $vagrantBundle;
    }
}
