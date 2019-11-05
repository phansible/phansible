<?php

namespace Phansible\Model;

use Github\Client;
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
    private $resources = ['contributors' => 'repos'];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a resource information.
     *
     * @param  string $resource The name of the resource. Should be a key in $resources.
     * @return array
     * @throws InvalidArgumentException If the requested resource is not in the list of valid ones.
     */
    public function get($resource)
    {
        if (!isset($this->resources[$resource])) {
            throw new InvalidArgumentException('The requested resource is not in the list');
        }

        return ($this->client->api($this->resources[$resource]))->statistics('phansible', 'phansible');
    }
}
