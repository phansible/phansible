<?php

namespace Phansible\Controller;

class AboutControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $twig;

    public function setUp()
    {
        $this->controller = new AboutController();
        $this->twig       = $this->getMockBuilder('\Twig_Environment')
            ->setMethods(['render'])
            ->getMock();
    }

    public function tearDown()
    {
        $this->controller = null;
        $this->twig = null;
    }

    /**
     * @covers \Phansible\Controller\AboutController::indexAction
     */
    public function testShouldRenderindexAction()
    {
        $container = new \Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('about.html.twig'),
                $this->arrayHasKey('contributors')
            );

        $container['twig'] = $this->twig;
        $container['config'] = [];
        $container['webservers'] = [];
        $container['boxes'] = [];
        $container['syspackages'] = [];
        $container['phppackages'] = [];

        $httpResponse = $this->getMockBuilder('\Guzzle\Http\Message\Response')
            ->setConstructorArgs([200])
            ->getMock();

        $httpClient = $this->getMockBuilder('\Github\HttpClient\CachedHttpClient')
            ->setMethods(['get'])
            ->getMock();

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(
                    'repos/Phansible/phansible/stats/contributors'
                )
            )
            ->will($this->returnValue($httpResponse));

        $client = $this->getMockBuilder('\Github\Client')
            ->setMethods(['getHttpClient'])
            ->getMock();

        $client->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $this->controller->setPimple($container);
        $this->controller->setGithubClient($client);
        $this->controller->indexAction();
    }

    /**
     * @covers \Phansible\Controller\DefaultController::getGithubClient
     */
    public function testShouldGetDefaultGithubClient()
    {
        $this->assertInstanceOf('\Github\Client', $this->controller->getGithubClient());
    }

    /**
     * @covers \Phansible\Controller\DefaultController::getGithubClient
     * @covers \Phansible\Controller\DefaultController::setGithubClient
     */
    public function testShouldSetAndGetGithubClient()
    {
        $client = $this->getMock('\Github\Client');

        $this->controller->setGithubClient($client);
        $this->assertSame($client, $this->controller->getGithubClient());
    }
}
