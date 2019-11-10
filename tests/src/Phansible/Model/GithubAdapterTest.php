<?php

namespace App\Phansible\Model;

use Github\Client;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Github\Api\Repo;

class GithubAdapterTest extends TestCase
{
    public function testThatGetRetrievesListOfContributors(): void
    {
        $httpResponse = ['user' => 'data'];

        $repo = $this->createMock(Repo::class);

        $repo->expects($this->once())
            ->method('statistics')
            ->willReturn($httpResponse);

        $client = $this->createMock(Client::class);

        $client->expects($this->once())
            ->method('api')
            ->willReturn($repo);

        $adapter = new GithubAdapter($client);

        $this->assertSame(
            ['user' => 'data'],
            $adapter->get('contributors')
        );
    }

    public function testThatANotValidResourceThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adapter = new GithubAdapter($client);

        $adapter->get('NotValidResource');
    }
}
