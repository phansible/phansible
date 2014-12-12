<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Github\Client;
use Github\HttpClient\CachedHttpClient;
use Github\HttpClient\Message\ResponseMediator;

class AboutController extends Controller
{
    /**
     * @var Client
     */
    private $githubClient;

    public function indexAction()
    {
        $response = $this->getGithubClient()
            ->getHttpClient()
            ->get('repos/Phansible/phansible/stats/contributors');

        $contributors = ResponseMediator::getContent($response);

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }

    public function getGithubClient()
    {
        if (null === $this->githubClient) {
            $this->githubClient = new Client(
                new CachedHttpClient(
                    ['cache_dir' => __DIR__ . '/../../../app/cache/github-api-cache']
                )
            );
        }

        return $this->githubClient;
    }

    public function setGithubClient(Client $client)
    {
        $this->githubClient = $client;
        return $this;
    }
}