<?php

namespace Phansible\Controller;

use Phansible\Application;
use Phansible\RoleManager;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
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
