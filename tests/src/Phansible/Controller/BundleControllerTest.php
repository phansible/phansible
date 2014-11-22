<?php
/**
 * BundleController Test
 */

namespace Phansible\Controller;

use Phansible\Application;
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
            'mariadb' => [
                'name' => 'MariaDB',
                'include' => [
                    'mariadb',
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
     * @covers \Phansible\Controller\BundleController::getPhpPackages
     */
    public function testPhpPackagesAreUnique()
    {
        $this->controller->setPhpPackages(['php5-xdebug', 'php5-xdebug']);

        $this->assertCount(1, $this->controller->getPhpPackages());
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
            ->with('ipAddress')
            ->will($this->returnValue('192.168.11.12'));
        $this->request->expects($this->at(3))
            ->method('get')
            ->with('timezone')
            ->will($this->returnValue('UTC'));

        $playbook = $this->controller->getPlaybook($this->request);

        $this->assertInstanceOf('Phansible\Renderer\PlaybookRenderer', $playbook);
    }

    /**
     * @dataProvider getVagrantfileProvider
     * @covers \Phansible\Controller\BundleController::getVagrantfile
     */
    public function testGetVagrantfile($useCloud)
    {
        $this->request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) use ($useCloud){
                $params = array(
                    'vmname' => 'VMName',
                    'baseBox' => 'precise64',
                    'memory'  => '512',
                    'ipAddress' => '192.168.11.11',
                    'sharedFolder' => './',
                    'enableWindows' => '1',
                    'syncType' => 'nfs',
                    'useVagrantCloud' => $useCloud,
                );

                return isset($params[$key])?$params[$key]:null;
            }));

        $vagrantfile = $this->controller->getVagrantfile($this->request);

        $this->assertInstanceOf('Phansible\Renderer\VagrantfileRenderer', $vagrantfile);
        $this->assertSame('VMName', $vagrantfile->getName());
        $this->assertSame('512', $vagrantfile->getMemory());
    }

    public function getVagrantfileProvider()
    {
        return array(
            array('1'),
            array('0'),
        );
    }

    /**
     * @dataProvider setupDatabaseProvider
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSetupDatabase($database, $expectsResult)
    {
        $this->request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) use ($database){
                $param = array(
                    'dbserver' => $database,
                    'root_password' => 'root_pass',
                    'user'     => 'user',
                    'password' => 'pass',
                    'database' => 'db',
                );

                return isset($param[$key])?$param[$key]:null;
            }));

        $playbook = new PlaybookRenderer();

        if ($expectsResult) {
            $this->controller->setupDatabase($playbook, $this->request);
            $this->assertContains($database, $playbook->getRoles());
            $varFiles = $playbook->getVarsFiles();
            $this->assertArrayHasKey(0, $varFiles);
            $this->assertArrayNotHasKey(1, $varFiles);
            $varFile = $varFiles[0];
            $this->assertInstanceof('\Phansible\Renderer\VarfileRenderer', $varFile);
            $this->assertEquals(array('variables' => array('db_vars' => array(array(
                'user' => 'user',
                'pass' => 'pass',
                'root_pass' => 'root_pass',
                'db' => 'db',
            )))), $varFile->getData());
        } else {
            $this->assertNull($this->controller->setupDatabase($playbook, $this->request));
        }
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupDatabase
     */
    public function testSelectingMysqlEnablesPhpMysqlPackage()
    {
        $playbook = new PlaybookRenderer();
        $this->request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) {
                        $param = array(
                            'dbserver' => 'mysql',
                            'user'     => 'user',
                            'password' => 'pass',
                            'root_password' => 'root_pass',
                            'database' => 'db',
                        );

                        return isset($param[$key])?$param[$key]:null;
                    }));

        $this->controller->setupDatabase($playbook, $this->request);

        $this->assertContains('php5-mysql', $this->controller->getPhpPackages());
    }

    public function setupDatabaseProvider()
    {
        return array(
            array('pgsql', true),
            array('mysql', true),
            array('mariadb', true),
            array('foo', false),
            array('', false),
        );
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
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->setMethods(['stream'])
            ->getMock();

        $path = __DIR__ . '/_assets/test';
        $app->expects($this->once())
            ->method('stream')
            ->will($this->returnCallback(function($callback, $status, $headers){
                return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, $status, $headers);
            }));

        $result = $this->controller->outputBundle($path, $app, 'foobar');

        ob_start();
        $result->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals(file_get_contents($path), $content);
    }

}
