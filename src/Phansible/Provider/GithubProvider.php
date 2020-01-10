<?php

namespace App\Phansible\Provider;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use App\Phansible\Model\GithubAdapter;
use Silex\Application;
use Silex\ServiceProviderInterface;

class GithubProvider //implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    //public function register(Application $app): void
    public function register(): void
    {
        $app['github'] = static function () {
            $filesystemAdapter = new Local(__DIR__ . '/../../../app/cache/github-api-cache');
            $filesystem        = new Filesystem($filesystemAdapter);
            $cache             = new FilesystemCachePool($filesystem);

            $client = new Client();
            $client->addCache($cache);

            return new GithubAdapter($client);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app): void
    {
    }
}
