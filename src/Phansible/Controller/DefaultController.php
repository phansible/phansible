<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;

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
}
