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

        $github = $this->getMockBuilder('\Phansible\Model\GithubAdapter')
            ->disableOriginalConstructor()
            ->getMock();
        $github->expects($this->any())
            ->method('get')
            ->will($this->returnValue(['contributors-data']));

        $container['twig'] = $this->twig;
        $container['config'] = [];
        $container['webservers'] = [];
        $container['boxes'] = [];
        $container['syspackages'] = [];
        $container['phppackages'] = [];
        $container['github'] = $github;

        $this->controller->setPimple($container);

        $this->controller->indexAction();
    }
}
