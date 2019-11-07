<?php

namespace Phansible\Model;

use Github\Client;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GithubAdapterTest extends TestCase
{
    public function testThatGetRetrievesListOfContributors()
    {
        $httpResponse = '{"user": "data"}';

        $repo = $this->createMock('Github\Api\Repo');

        $repo->expects($this->once())
            ->method('statistics')
            ->will($this->returnValue($httpResponse));

        $client = $this->createMock('Github\Client');

        $client->expects($this->once())
            ->method('api')
            ->will($this->returnValue($repo));

        $adapter = new GithubAdapter($client);

        $this->assertSame(
            '{"user": "data"}',
            $adapter->get('contributors')
        );
    }

    public function testThatANotValidResourceThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adapter = new GithubAdapter($client);

        $adapter->get('NotValidResource');
    }
}
