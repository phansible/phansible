<?php

namespace Phansible\Model;

class GithubAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testThatGetRetrievesListOfContributors()
    {
        $httpResponse = new \Guzzle\Http\Message\Response(200, null, '{"user": "data"}');

        $client = $this->getMockBuilder('\Github\HttpClient\CachedHttpClient')
            ->disableOriginalConstructor()
            ->getMock();
        $client->expects($this->once())
            ->method('get')
            ->will($this->returnValue($httpResponse));

        $adapter = new GithubAdapter($client);

        $this->assertSame(
            ['user' => 'data'],
            $adapter->get('contributors')
        );
    }

    public function testThatANotValidResourceThrowsException()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $client = $this->getMockBuilder('\Github\HttpClient\CachedHttpClient')
            ->disableOriginalConstructor()
            ->getMock();

        $adapter = new GithubAdapter($client);

        $adapter->get('NotValidResource');
    }
}
