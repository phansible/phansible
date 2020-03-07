<?php

namespace App\Phansible\Controller;

use App\Phansible\RolesManager;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;

/**
 * @package Phansible
 */
class DefaultController extends AbstractController
{
    /**
     * @var RolesManager
     */
    private $rolesManager;

    /**
     * AboutController constructor.
     * @param RolesManager $rolesManager
     */
    public function __construct(RolesManager $rolesManager)
    {
        $this->rolesManager = $rolesManager;
    }

    public function indexAction(): Response
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/../../../config/config.yaml'));

        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/boxes.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/webservers.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/syspackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/phppackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/databases.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/workers.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/peclpackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/rabbitmqplugins.yaml')));

        $config['timezones'] = DateTimeZone::listIdentifiers();

        $initialValues = $this->rolesManager->getInitialValues();

        $config = ['config' => $config];

        return $this->render('index.html.twig', array_merge($initialValues, $config));
    }

    public function docsAction($doc): Response
    {
        if (!in_array($doc, ['contributing', 'customize', 'usage', 'vagrant'])) {
            throw new NotFoundHttpException();
        }

        $docfile = __DIR__ . '/../Resources/docs' . DIRECTORY_SEPARATOR . $doc . '.md';

        $content = '';

        if (is_file($docfile)) {
            $content = file_get_contents($docfile);
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }
}
