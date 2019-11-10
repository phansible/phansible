<?php

namespace App\Phansible\Controller;

use DateTimeZone;
use Michelf\Markdown;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package Phansible
 */
class DefaultController extends AbstractController
{
    public function indexAction(): Response
    {
        $config = $this->get('config');

        $config['boxes']           = $this->get('boxes');
        $config['webservers']      = $this->get('webservers');
        $config['syspackages']     = $this->get('syspackages');
        $config['phppackages']     = $this->get('phppackages');
        $config['databases']       = $this->get('databases');
        $config['workers']         = $this->get('workers');
        $config['peclpackages']    = $this->get('peclpackages');
        $config['rabbitmqplugins'] = $this->get('rabbitmqplugins');

        $config['timezones'] = DateTimeZone::listIdentifiers();

        $roles = $this->get('roles');

        $initialValues = $roles->getInitialValues();
        $config        = ['config' => $config];

        return $this->render('index.html.twig', array_merge($initialValues, $config));
    }

    public function docsAction($doc): Response
    {
        if (!in_array($doc, ['contributing', 'customize', 'usage', 'vagrant'])) {
            throw new NotFoundHttpException();
        }
        $docfile = $this->get('docs.path') . DIRECTORY_SEPARATOR . $doc . '.md';

        $content = '';

        if (is_file($docfile)) {
            $content = Markdown::defaultTransform(file_get_contents($docfile));
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }
}
