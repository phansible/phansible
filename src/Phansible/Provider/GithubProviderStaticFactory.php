<?php

namespace App\Phansible\Provider;

use App\Phansible\Model\GithubAdapter;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Class GithubProviderStaticFactory
 * @package App\Phansible\Provider
 */
class GithubProviderStaticFactory
{
    /**
     * @return GithubAdapter
     */
    public static function create(): GithubAdapter
    {
        $filesystemAdapter = new Local(__DIR__ . '/../../../var/cache/github-api-cache');
        $filesystem        = new Filesystem($filesystemAdapter);
        $cache             = new FilesystemCachePool($filesystem);

        $client = new Client();
        $client->addCache($cache);

        return new GithubAdapter($client);
    }
}
