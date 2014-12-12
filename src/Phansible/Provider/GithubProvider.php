<?php

namespace Phansible\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Github\Client;
use Phansible\Model\GithubAdapter;
use Github\HttpClient\CachedHttpClient;

class GithubProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['github'] = $app->share(
            function () {
                $client = new Client(new CachedHttpClient(
                    ['cache_dir' => __DIR__ . '/../../../app/cache/github-api-cache']
                ));

                return new GithubAdapter($client->getHttpClient());
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
