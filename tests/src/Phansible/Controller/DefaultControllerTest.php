<?php

namespace Phansible\Controller;

use Phansible\Application;
use Phansible\RoleManager;

class DefaultControllerTests extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $twig;

    public function setUp()
    {
        parent::setUp();

        $this->controller = new DefaultController();
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
     * @covers \Phansible\Controller\DefaultController::indexAction
     */
    public function testShouldRenderIndexAction()
    {
        $container = new \Pimple();
        $app = new Application(__DIR__ . '/..');

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('index.html.twig'),
                $this->arrayHasKey('config')
            );

        $container['twig']         = $this->twig;
        $container['config']       = [];
        $container['webservers']   = [];
        $container['boxes']        = [];
        $container['syspackages']  = [];
        $container['phppackages']  = [];
        $container['databases']    = [];
        $container['peclpackages'] = [];
        $container['roles']        = new RoleManager($app);

        $this->controller->setPimple($container);
        $this->controller->indexAction();
    }

    /**
     * @covers \Phansible\Controller\DefaultController::aboutAction
     */
    public function testShouldRenderAboutAction()
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

        $this->controller->setPimple($container);
        $this->controller->aboutAction();
    }

    /**
     * @covers \Phansible\Controller\DefaultController::docsAction
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testShouldThrowExceptionWhenDocFileNotExists()
    {
        $doc = '';
        $this->controller->docsAction($doc);
    }

    /**
     * @covers \Phansible\Controller\DefaultController::docsAction
     */
    public function testShouldRenderDocsActionWhenFileExists()
    {
        $container = new \Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('docs.html.twig'),
                $this->callback(function ($param) {
                    return array_key_exists('content', $param) && strpos($param['content'], 'ansible');
                })
            );

        $docFile = new \SplFileObject('/tmp/vagrant.md', 'w+');
        $docFile->fwrite('Phansible');

        $doc = 'vagrant';

        $container['twig'] = $this->twig;
        $container['docs.path'] = '/tmp';

        $this->controller->setPimple($container);
        $this->controller->docsAction($doc);

        unlink($docFile->getPathname());
    }
}
