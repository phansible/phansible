<?php

namespace Phansible\Model;

class GithubAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testThatGetRetrievesListOfContributors()
    {
        $response = ['user' => 'data'];

        $httpResponse = $this->getMockBuilder('\Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $httpResponse->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('{"user": "data"}'));

        $client = $this->getMockBuilder('\Github\HttpClient\CachedHttpClient')
            ->disableOriginalConstructor()
            ->getMock();
        $client->expects($this->once())
            ->method('get')
            ->will($this->returnValue($httpResponse));

        $adapter = new GithubAdapter($client);

        $this->assertSame(
            $response,
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
