<?php

namespace Phansible\Model;

use Github\HttpClient\HttpClient;
use Github\HttpClient\Message\ResponseMediator;
use InvalidArgumentException;

/**
 * An adapter that simplifies dependencies with the Github SDK.
 */
class GithubAdapter
{
    /**
     * Github SDK HttpClient.
     *
     * @var HttpClient
     */
    private $client;

    /**
     * A list of resources we are able to query.
     *
     * @var string[]
     */
    private $resources = ['contributors' => 'repos/Phansible/phansible/stats/contributors'];

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a resource information.
     *
     * @param  string $resource The name of the resource. Should be a key in $resources.
     * @return array
     */
    public function get($resource)
    {
        if (!isset($this->resources[$resource])) {
            throw new InvalidArgumentException('The requested resource is not in the list');
        }

        return ResponseMediator::getContent($this->client->get($this->resources[$resource]));
    }
}