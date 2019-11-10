<?php

namespace App\Phansible\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Phansible
 */
class AboutController extends AbstractController
{
    public function indexAction(): Response
    {
        $contributors = array_reverse($this->pimple['github']->get('contributors'));

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }
}
