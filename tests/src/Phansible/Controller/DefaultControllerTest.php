<?php

namespace Phansible\Controller;

use Phansible\RoleManager;
use PHPUnit\Framework\TestCase;
use Pimple;
use SplFileObject;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultControllerTest extends TestCase
{
    private $controller;
    private $twig;

    public function setUp(): void
    {
        $this->controller = new DefaultController();
        $this->twig       = $this->getMockBuilder(\Twig_Environment::class)
            ->onlyMethods(['render'])
            ->getMock();
    }

    public function tearDown(): void
    {
        $this->controller = null;
        $this->twig       = null;
    }

    /**
     * @covers \Phansible\Controller\DefaultController::indexAction
     */
    public function testShouldRenderIndexAction(): void
    {
        $container = new Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('index.html.twig'),
                $this->arrayHasKey('config')
            );

        $container['twig']            = $this->twig;
        $container['config']          = [];
        $container['webservers']      = [];
        $container['boxes']           = [];
        $container['syspackages']     = [];
        $container['phppackages']     = [];
        $container['databases']       = [];
        $container['workers']         = [];
        $container['peclpackages']    = [];
        $container['rabbitmqplugins'] = [];
        $container['roles']           = new RoleManager();

        $this->controller->setPimple($container);
        $this->controller->indexAction();
    }

    /**
     * @covers \Phansible\Controller\DefaultController::docsAction
     * @expectException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testShouldThrowExceptionWhenDocFileNotExists(): void
    {
        $doc = '';
        $this->expectException(NotFoundHttpException::class);
        $this->controller->docsAction($doc);
    }

    /**
     * @covers \Phansible\Controller\DefaultController::docsAction
     */
    public function testShouldRenderDocsActionWhenFileExists(): void
    {
        $container = new Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('docs.html.twig'),
                $this->callback(function ($param) {
                    return array_key_exists('content', $param) && strpos($param['content'], 'ansible');
                })
            );

        $docFile = new SplFileObject('/tmp/vagrant.md', 'w+');
        $docFile->fwrite('Phansible');

        $doc = 'vagrant';

        $container['twig']      = $this->twig;
        $container['docs.path'] = '/tmp';

        $this->controller->setPimple($container);
        $this->controller->docsAction($doc);

        unlink($docFile->getPathname());
    }
}
