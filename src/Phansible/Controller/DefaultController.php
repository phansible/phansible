<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Michelf\Markdown;
use DateTimeZone;

/**
 * @package Skeleton
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        $config = $this->get('config');

        $config['boxes']       = $this->get('boxes');
        $config['webservers']  = $this->get('webservers');
        $config['syspackages'] = $this->get('syspackages');
        $config['phppackages'] = $this->get('phppackages');

        $config['timezones'] = DateTimeZone::listIdentifiers();

        return $this->render('index.html.twig', ['config' => $config]);
    }

    public function usageAction($doc)
    {
        $docfile = $this->get('docs.path') . DIRECTORY_SEPARATOR . $doc . '.md';

        $content = "";

        if (is_file($docfile)) {
            $content = Markdown::defaultTransform(file_get_contents($docfile));
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }
}
