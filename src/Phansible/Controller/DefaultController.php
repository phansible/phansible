<?php

namespace Phansible\Controller;

use Flint\Controller\Controller;
use Github\Client;
use Github\HttpClient\CachedHttpClient;
use Github\HttpClient\Message\ResponseMediator;
use Michelf\Markdown;
use DateTimeZone;
use Phansible\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $config['boxes']        = $this->get('boxes');
        $config['webservers']   = $this->get('webservers');
        $config['syspackages']  = $this->get('syspackages');
        $config['phppackages']  = $this->get('phppackages');
        $config['databases']    = $this->get('databases');
        $config['peclpackages'] = $this->get('peclpackages');

        $config['timezones'] = DateTimeZone::listIdentifiers();

        $roles = $this->get('roles');

        $initialValues = $roles->getInitialValues();
        $config = ['config' => $config];
        return $this->render('index.html.twig', array_merge($initialValues, $config));
    }

    public function docsAction($doc)
    {
        if (!in_array($doc, ['contributing', 'customize', 'usage', 'vagrant'])) {
            throw new NotFoundHttpException();
        }
        $docfile = $this->get('docs.path') . DIRECTORY_SEPARATOR . $doc . '.md';

        $content = "";

        if (is_file($docfile)) {
            $content = Markdown::defaultTransform(file_get_contents($docfile));
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }

    public function aboutAction()
    {
        $client = new Client(
            new CachedHttpClient(
                ['cache_dir' => __DIR__ . '/../../../app/cache/github-api-cache']
            )
        );

        $response = $client->getHttpClient()->get('repos/Phansible/phansible/stats/contributors');
        $contributors = ResponseMediator::getContent($response);

        return $this->render('about.html.twig', ['contributors' => $contributors]);
    }
}
