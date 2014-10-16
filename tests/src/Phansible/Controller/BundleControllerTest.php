<?php
/**
 * BundleController Test
 */

namespace Phansible\Controller;

use Phansible\Renderer\PlaybookRenderer;

class BundleControllerTest extends \PHPUnit_Framework_TestCase
{
    /* @var BundleController */
    private $controller;
    private $container;
    private $twig;
    private $config;
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->controller = new BundleController();
        $this->twig       = $this->getMockBuilder('\Twig_Environment')
            ->setMethods(['render'])
            ->getMock();

        $webservers = [
            'nginxphp' => [
                'name' => 'NGINX + PHP5-FPM',
                'include' => [ 'nginx', 'php5-fpm' ]
            ]
        ];

        $boxes = [
            'virtualbox' => [
                'precise32' => [
                    'name'  => 'Ubuntu Precise Pangolin (12.04) 32',
                    'url'   => 'https://vagrantcloud.com/hashicorp/precise32/version/1/provider/virtualbox.box',
                    'cloud' => 'hashicorp/precise32'
                ],
                'precise64' => [
                    'name'  => 'Ubuntu Precise Pangolin (12.04) 64',
                    'url'   => 'https://vagrantcloud.com/hashicorp/precise64/version/2/provider/virtualbox.box',
                    'cloud' => 'hashicorp/precise64'
                ],
            ],
        ];

        $databases = [
            'mysql' => [
                'name' => 'MySQL',
                'checked' => 'yes',
                'include' => [
                    'mysql',
                ]
            ],
            'pgsql' => [
                'name' => 'PostgreSQL',
                'include' => [
                    'postgresql-9.3',
                ]
            ],
        ];

        $this->container = new \Pimple();
        $this->container['webservers'] = $webservers;
        $this->container['boxes'] = $boxes;
        $this->container['databases'] = $databases;

        $this->controller->setPimple($this->container);

        $this->request = $this->createRequest();
    }

    private function createRequest()
    {
        $request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        return $request;
    }

    public function tearDown()
    {
        $this->controller = null;
        $this->twig = null;
    }

    /**
     * @covers \Phansible\Controller\BundleController::addPhpPackage
     * @covers \Phansible\Controller\BundleController::setPhpPackages
     * @covers \Phansible\Controller\BundleController::getPhpPackages
     */
    public function testGetAndSetPhpPackages()
    {
        $this->controller->addPhpPackage('php5-xdebug');

        $this->assertContains('php5-xdebug', $this->controller->getPhpPackages());

        $this->controller->setPhpPackages(['php5-xdebug', 'php5-curl']);

        $this->assertContains('php5-curl', $this->controller->getPhpPackages());
    }

    /**
     * @covers \Phansible\Controller\BundleController::getInventory
     */
    public function testGetInventory()
    {
        $this->request->expects($this->once())
            ->method('get')
            ->with('ipAddress')
            ->will($this->returnValue(1));

        $playbook = $this->controller->getInventory($this->request);

        $this->assertInstanceOf('Phansible\Renderer\TemplateRenderer', $playbook);
    }

    /**
     * @covers \Phansible\Controller\BundleController::getPlaybook
     */
    public function testGetPlaybook()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('webserver')
            ->will($this->returnValue(1));
        $this->request->expects($this->at(1))
            ->method('get')
            ->with('servername')
            ->will($this->returnValue('myShinyNewApp.io'));
        $this->request->expects($this->at(2))
            ->method('get')
            ->with('timezone')
            ->will($this->returnValue('UTC'));

        $playbook = $this->controller->getPlaybook($this->request);

        $this->assertInstanceOf('Phansible\Renderer\PlaybookRenderer', $playbook);
    }

    /**
     * @covers \Phansible\Controller\BundleController::getVagrantfile
     */
    public function testGetVagrantfile()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('vmname')
            ->will($this->returnValue('VMName'));

        $this->request->expects($this->at(1))
            ->method('get')
            ->with('baseBox')
            ->will($this->returnValue('precise64'));

        $this->request->expects($this->at(2))
            ->method('get')
            ->with('memory')
            ->will($this->returnValue('512'));

        $this->request->expects($this->at(3))
            ->method('get')
            ->with('ipAddress')
            ->will($this->returnValue('192.168.11.11'));

        $this->request->expects($this->at(4))
            ->method('get')
            ->with('sharedFolder')
            ->will($this->returnValue('./'));

        $this->request->expects($this->at(5))
            ->method('get')
            ->with('enableWindows')
            ->will($this->returnValue('1'));

        $this->request->expects($this->at(6))
            ->method('get')
            ->with('syncType')
            ->will($this->returnValue('nfs'));

        $this->request->expects($this->at(7))
            ->method('get')
            ->with('useVagrantCloud')
            ->will($this->returnValue('1'));

        $vagrantfile = $this->controller->getVagrantfile($this->request);

        $this->assertInstanceOf('Phansible\Renderer\VagrantfileRenderer', $vagrantfile);
        $this->assertSame('VMName', $vagrantfile->getName());
        $this->assertSame('512', $vagrantfile->getMemory());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSetupMysql()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('dbserver')
            ->will($this->returnValue('mysql'));

        $this->request->expects($this->at(1))
            ->method('get')
            ->with('user')
            ->will($this->returnValue('user'));

        $this->request->expects($this->at(2))
            ->method('get')
            ->with('password')
            ->will($this->returnValue('pass'));

        $this->request->expects($this->at(3))
            ->method('get')
            ->with('database')
            ->will($this->returnValue('db'));

        $playbook = new PlaybookRenderer();

        $this->controller->setupDatabase($playbook, $this->request);

        $this->assertContains('mysql', $playbook->getRoles());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSetupPostgreSQL()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('dbserver')
            ->will($this->returnValue('pgsql'));

        $this->request->expects($this->at(1))
            ->method('get')
            ->with('user')
            ->will($this->returnValue('user'));

        $this->request->expects($this->at(2))
            ->method('get')
            ->with('password')
            ->will($this->returnValue('pass'));

        $this->request->expects($this->at(3))
            ->method('get')
            ->with('database')
            ->will($this->returnValue('db'));

        $playbook = new PlaybookRenderer();

        $this->controller->setupDatabase($playbook, $this->request);

        $this->assertContains('pgsql', $playbook->getRoles());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSetupDBWithWrongDB()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('dbserver')
            ->will($this->returnValue('mariadb'));

        $playbook = new PlaybookRenderer();

        $this->assertNull($this->controller->setupDatabase($playbook, $this->request));

    }

    /**
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSetupDBWithoutDB()
    {
        $this->request->expects($this->at(0))
            ->method('get')
            ->with('dbserver')
            ->will($this->returnValue(''));

        $playbook = new PlaybookRenderer();

        $this->assertNull($this->controller->setupDatabase($playbook, $this->request));

    }

    /**
     * @covers \Phansible\Controller\BundleController::setupComposer
     */
    public function testSetupComposer()
    {
        $this->request->expects($this->once())
            ->method('get')
            ->with('composer')
            ->will($this->returnValue(1));

        $playbook = new PlaybookRenderer();

        $this->controller->setupComposer($playbook, $this->request);

        $this->assertContains('composer', $playbook->getRoles());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupXDebug
     */
    public function testSetupXdebug()
    {
        $this->request->expects($this->once())
            ->method('get')
            ->with('xdebug')
            ->will($this->returnValue(1));

        $playbook = new PlaybookRenderer();

        $this->controller->setupXDebug($playbook, $this->request);

        $this->assertContains('php5-xdebug', $this->controller->getPhpPackages());
    }

    /**
     * @covers \Phansible\Controller\BundleController::getWebServer
     */
    public function testGetWebServer()
    {
        $webserver = $this->controller->getWebServer('nginxphp');

        $this->assertArrayHasKey('name', $webserver);
    }

    /**
     * @covers \Phansible\Controller\BundleController::getBox
     */
    public function testGetBox()
    {
        $box = $this->controller->getBox('precise64');

        $this->assertArrayHasKey('name', $box);
        $this->assertEquals(
            'https://vagrantcloud.com/hashicorp/precise64/version/2/provider/virtualbox.box',
            $box['url']
        );
    }

    public function testOutputBundle()
    {

    }
}
