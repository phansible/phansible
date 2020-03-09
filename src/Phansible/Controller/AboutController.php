<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\GithubAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AboutController
 * @package App\Phansible\Controller
 */
class AboutController extends AbstractController
{
    /**
     * @var GithubAdapter
     */
    private $githubAdapter;

    /**
     * AboutController constructor.
     * @param GithubAdapter $githubAdapter
     */
    public function __construct(GithubAdapter $githubAdapter)
    {
        $this->githubAdapter = $githubAdapter;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $contributors = array_reverse($this->githubAdapter->get('contributors'));

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }
}
