<?php

namespace Phansible\Controller;

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
     */
    public function testShouldRenderUsageActionWhenDocFileNotExists()
    {
        $container = new \Pimple();

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('docs.html.twig'),
                $this->equalTo(['content' => ''])
            );

        $container['twig'] = $this->twig;
        $container['docs.path'] = '';
        $doc = '';

        $this->controller->setPimple($container);
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

        $docFile = new \SplFileObject('/tmp/phansible.md', 'w+');
        $docFile->fwrite('Phansible');

        $doc = 'phansible';

        $container['twig'] = $this->twig;
        $container['docs.path'] = '/tmp';

        $this->controller->setPimple($container);
        $this->controller->docsAction($doc);

        unlink($docFile->getPathname());
    }
}
