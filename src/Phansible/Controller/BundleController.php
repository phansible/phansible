<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\PlaybookRenderer;
use App\Phansible\Renderer\TemplateRenderer;
use App\Phansible\Renderer\VarfileRenderer;
use App\Phansible\RolesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @package Phansible
 */
class BundleController extends AbstractController
{
    /**
     * @var RolesManager
     */
    private $rolesManager;

    /**
     * @var VagrantBundle
     */
    private $vagrantBundle;

    /**
     * AboutController constructor.
     * @param RolesManager $rolesManager
     */
    public function __construct(RolesManager $rolesManager)
    {
        $this->rolesManager = $rolesManager;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
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

        $this->rolesManager->setupRole($requestVars, $this->getVagrantBundle());
        $playbook->addRole('app');

        $zipPath = tempnam(sys_get_temp_dir(), 'phansible_bundle_');

        if ($this->getVagrantBundle()->generateBundle(
            $zipPath,
            $playbook->getRoles()
        )
        ) {
            $vagrantfile = $this->getVagrantBundle()->getVagrantFile();

            return $this->outputBundle($zipPath, $vagrantfile->getName());
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
            $twig = new Environment(
                new FilesystemLoader(__DIR__ . '/../Resources/ansible/templates')
            );

            $this->vagrantBundle = new VagrantBundle(
                __DIR__ . '/../Resources/ansible',
                $twig
            );
        }

        return $this->vagrantBundle;
    }

    /**
     * @param string $zipPath
     * @param string $filename
     * @return Response
     */
    private function outputBundle($zipPath, $filename): Response
    {
//        $stream = static function () use ($zipPath) {
//            echo file_get_contents($zipPath);
//            unlink($zipPath);
//        };
//
//        $response = $app->stream(
//            $stream,
//            Response::HTTP_OK,
//            array(
//                'Content-length' => filesize($zipPath),
//                'Content-Type'   => 'application/zip',
//                'Pragma'         => 'no-cache',
//                'Cache-Control'  => 'no-cache',
//            )
//        );
//
//        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
//            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
//            'phansible_' . $filename . '.zip'
//        ));
        $fileContent = file_get_contents($zipPath);

        unlink($zipPath);

        $response = new Response($fileContent);

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'phansible_' . $filename . '.zip'
        );

        $response->headers->set('Content-Disposition', $disposition);

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
