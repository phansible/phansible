<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\GithubAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Phansible
 */
class AboutController extends AbstractController
{
//    /**
//     * @var GithubAdapter
//     */
//    private $githubAdapter;
//
//    /**
//     * AboutController constructor.
//     * @param GithubAdapter $githubAdapter
//     */
//    public function __construct(GithubAdapter $githubAdapter)
//    {
//       $this->githubAdapter = $githubAdapter;
//
//    }

    public function indexAction(): Response
    {
        var_dump($this->container->get(GithubAdapter::class));die;
//        $contributors = array_reverse($this->pimple['github']->get('contributors'));
        $contributors = array_reverse($this->githubAdapter->get('contributors'));

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }
}
