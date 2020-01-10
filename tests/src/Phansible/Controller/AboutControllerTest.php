<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\GithubAdapter;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class AboutControllerTest extends TestCase
{
    private $controller;
    private $twig;

    public function setUp(): void
    {
        $this->controller = new AboutController();
        $this->twig       = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();
    }

    public function tearDown(): void
    {
        $this->controller = null;
        $this->twig       = null;
    }

    /**
     * @covers \App\Phansible\Controller\AboutController::indexAction
     */
    public function testShouldRenderindexAction(): void
    {
//        $container = new Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('about.html.twig'),
                $this->arrayHasKey('contributors')
            );

        $github = $this->getMockBuilder(GithubAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $github->expects($this->any())
            ->method('get')
            ->willReturn(['contributors-data']);

//        $container['twig']        = $this->twig;
//        $container['config']      = [];
//        $container['webservers']  = [];
//        $container['boxes']       = [];
//        $container['syspackages'] = [];
//        $container['phppackages'] = [];
//        $container['github']      = $github;
//
//        $this->controller->setPimple($container);

        $this->controller->indexAction($github);
    }
}
