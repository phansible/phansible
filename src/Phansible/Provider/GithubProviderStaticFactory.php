<?php

namespace App\Phansible\Provider;

use App\Phansible\Model\GithubAdapter;
use Github\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
        // Use Symfony FilesystemAdapter (PSR-6)
        $cache = new FilesystemAdapter(
            namespace: 'github_api',
            defaultLifetime: 0,
            directory: __DIR__ . '/../../../var/cache/github-api-cache'
        );

        $client = new Client();
        $client->addCache($cache);

        return new GithubAdapter($client);
    }
}
