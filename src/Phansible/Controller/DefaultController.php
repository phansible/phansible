<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Michelf\Markdown;

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
        return $this->render('index.html.twig', [
            'config' => $this->get('config'),
        ]);
    }

    public function usageAction($doc)
    {
        $docfile = __DIR__ . '/../Resources/docs/' . $doc . '.md';
        $content = "";

        if (is_file($docfile)) {
            $content = Markdown::defaultTransform(file_get_contents($docfile));
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }
}
