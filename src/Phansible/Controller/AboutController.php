<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;

/**
 * @package Phansible
 */
class AboutController extends Controller
{
    public function indexAction()
    {
        $contributors = array_reverse($this->pimple['github']->get('contributors'));

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }
}