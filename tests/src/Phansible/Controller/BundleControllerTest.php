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
                    'deb'   => 'precise',
                    'url'   => 'https://vagrantcloud.com/hashicorp/precise32/version/1/provider/virtualbox.box',
                    'cloud' => 'hashicorp/precise32'
                ],
                'precise64' => [
                    'name'  => 'Ubuntu Precise Pangolin (12.04) 64',
                    'deb'   => 'precise',
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
        $this->container['ansible.path'] = '';

        $this->controller->setPimple($this->container);

        $this->request = $this->createRequest();

        $this->php = \PHPUnit_Extension_FunctionMocker::start($this, 'Phansible\Controller')
            ->mockFunction('time')
            ->mockFunction('sys_get_temp_dir')
            ->mockFunction('filesize')
            ->getMock();
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
     */
    public function testSetupDatabase($database, $install, $expectsResult)
    {
        $this->request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) use ($database, $install) {

                $param = array($database => array(
                    'install' => $install,
                    'root-password' => 'root_pass',
                    'user'     => 'user',
                    'password' => 'pass',
                    'database' => 'db',
                ));

                return isset($param[$key])?$param[$key]:null;
            }));

        $playbook = new PlaybookRenderer();
        switch ($database) {
            case 'mysql':
                $controllerFunction = 'setupMysql';
                $expectedData = array(
                  'variables' => array(
                    'user' => 'user',
                    'password' => 'pass',
                    'root_password' => 'root_pass',
                    'database' => 'db',
                  ),
                  'name' => $database,
                );
                break;
            case 'mariadb':
                $controllerFunction = 'setupMariadb';
                $expectedData = array(
                  'variables' => array(
                    'user' => 'user',
                    'password' => 'pass',
                    'root_password' => 'root_pass',
                    'database' => 'db',
                  ),
                  'name' => $database,
                );
                break;
            case 'pgsql':
                $controllerFunction = 'setupPgsql';
                $expectedData = array(
                  'variables' => array(
                    'user' => 'user',
                    'password' => 'pass',
                    'database' => 'db',
                  ),
                  'name' => $database,
                );
                break;


        }

        if ($expectsResult) {
            $this->controller->$controllerFunction($playbook, $this->request);
            $this->assertContains($database, $playbook->getRoles());
            $varFiles = $playbook->getVarsFiles();
            $this->assertArrayHasKey(0, $varFiles);
            $this->assertArrayNotHasKey(1, $varFiles);
            $varFile = $varFiles[0];
            $this->assertInstanceof('\Phansible\Renderer\VarfileRenderer', $varFile);
            $this->assertEquals($expectedData, $varFile->getData());
        } else {
            $this->assertNull($this->controller->$controllerFunction($playbook, $this->request));
        }
    }



    /**
     * @covers \Phansible\Controller\BundleController::setupMysql
     */
    public function testSelectingMysqlEnablesPhpMysqlPackage()
    {
        $playbook = new PlaybookRenderer();
        $this->request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) {
                        $param = array('mysql' => array(
                            'install' => 1,
                            'user'     => 'user',
                            'password' => 'password',
                            'root-password' => 'root-password',
                            'database' => 'database',
                        ));

                        return isset($param[$key])?$param[$key]:null;
                    }));

        $this->controller->setupMysql($playbook, $this->request);

        $this->assertContains('php5-mysql', $this->controller->getPhpPackages());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupMysql
     */
    public function testSelectingMariadbEnablesPhpMysqlPackage()
    {
        $playbook = new PlaybookRenderer();
        $this->request->expects($this->any())
          ->method('get')
          ->will($this->returnCallback(function($key) {
              $param = array('mariadb' => array(
                'install' => 1,
                'user'     => 'user',
                'password' => 'password',
                'root-password' => 'root-password',
                'database' => 'database',
              ));

              return isset($param[$key])?$param[$key]:null;
          }));

        $this->controller->setupMariadb($playbook, $this->request);

        $this->assertContains('php5-mysql', $this->controller->getPhpPackages());
    }

    /**
     * @covers \Phansible\Controller\BundleController::setupMysql
     */
    public function testSelectingPgsqlEnablesPhpPgsqlPackage()
    {
        $playbook = new PlaybookRenderer();
        $this->request->expects($this->any())
          ->method('get')
          ->will($this->returnCallback(function($key) {
              $param = array('pgsql' => array(
                'install' => 1,
                'user'     => 'user',
                'password' => 'password',
                'database' => 'database',
              ));

              return isset($param[$key])?$param[$key]:null;
          }));

        $this->controller->setupPgsql($playbook, $this->request);

        $this->assertContains('php5-pgsql', $this->controller->getPhpPackages());
    }

    public function setupDatabaseProvider()
    {
        return array(
            array('pgsql', 1, true),
            array('pgsql', 0, false),
            array('mysql', 1, true),
            array('mysql', 0, false),
            array('mariadb', 1, true),
            array('mariadb', 0, false),
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

    /**
     * @covers \Phansible\Controller\BundleController::getPeclPackages
     * @covers \Phansible\Controller\BundleController::setPeclPackages
     */
    public function testShouldSetAndGetPeclPackages()
    {
        $packages = [];

        $this->controller->setPeclPackages($packages);
        $this->assertEquals($packages, $this->controller->getPeclPackages());
    }

    /**
     * @covers \Phansible\Controller\BundleController::getVagrantBundle
     */
    public function testShouldGetDefaultInstanceOfVagrantBundle()
    {
        $this->assertInstanceOf('\Phansible\Model\VagrantBundle', $this->controller->getVagrantBundle());
    }

    /**
     * @covers \Phansible\Controller\BundleController::getVagrantBundle
     * @covers \Phansible\Controller\BundleController::setVagrantBundle
     */
    public function testShouldSetAndGetVagrantBlundle()
    {
        $vagrantBundle = $this->getMock('\Phansible\Model\VagrantBundle');

        $this->controller->setVagrantBundle($vagrantBundle);
        $this->assertSame($vagrantBundle, $this->controller->getVagrantBundle());
    }

    /**
     * @covers \Phansible\Controller\BundleController::indexAction
     */
    public function testShouldRetriveErrorWhenGenerateAnsibleFileFail()
    {
        $request = new \Symfony\Component\HttpFoundation\Request(['vmname' => 'test']);

        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $vagrantBundle = $this->getMockBuilder('\Phansible\Model\VagrantBundle')
            ->setMethods(['generateBundle'])
            ->getMock();

        $vagrantBundle->expects($this->once())
            ->method('generateBundle')
            ->will($this->returnValue(0));

        $result = $this->controller
            ->setVagrantBundle($vagrantBundle)
            ->indexAction($request, $app);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $result);
        $this->assertEquals('An error occurred.', $result->getContent());
    }

    /**
     * @covers \Phansible\Controller\BundleController::indexAction
     */
    public function testShouldGenerateAnsibleFile()
    {
        $request = new \Symfony\Component\HttpFoundation\Request(['vmname' => 'test']);

        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->setMethods(['stream'])
            ->getMock();

        $path = __DIR__ . '/_assets/test';

        $app->expects($this->once())
            ->method('stream')
            ->with(
                $this->anything(),
                $this->equalTo(200)
            )
            ->will($this->returnCallback(function($callback, $status, $headers){
                return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, $status, $headers);
            }));

        $vagrantBundle = $this->getMockBuilder('\Phansible\Model\VagrantBundle')
            ->setMethods(['setRenderers', 'addRenderer', 'generateBundle'])
            ->getMock();

        $vagrantBundle->expects($this->once())
            ->method('setRenderers')
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(1))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\PlaybookRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(2))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\VagrantfileRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(3))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\TemplateRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $this->php->expects($this->once())
            ->method('time')
            ->will($this->returnValue(123));

        $this->php->expects($this->once())
            ->method('sys_get_temp_dir')
            ->will($this->returnValue('/tmp'));

        $this->php->expects($this->once())
            ->method('filesize')
            ->with('/tmp/bundle_123.zip')
            ->will($this->returnValue(1000));

        $roles = [
            'init',
            'php5-cli',
            'nginx',
            'php5-fpm',
            'phpcommon',
            'app'
        ];

        $vagrantBundle->expects($this->once())
            ->method('generateBundle')
            ->with(
                $this->equalTo('/tmp/bundle_123.zip'),
                $roles
            )
            ->will($this->returnValue(1));

        $result = $this->controller
            ->setVagrantBundle($vagrantBundle)
            ->indexAction($request, $app);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\StreamedResponse', $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertArrayHasKey('content-length', $result->headers->all());
        $this->assertGreaterThan(0, $result->headers->get('content-length'));
        $this->assertArrayHasKey('content-disposition', $result->headers->all());
        $this->assertEquals('attachment; filename="phansible_test.zip"', $result->headers->get('content-disposition'));
        $this->assertArrayHasKey('content-type', $result->headers->all());
        $this->assertEquals('application/zip', $result->headers->get('content-type'));
    }

    /**
     * @covers \Phansible\Controller\BundleController::indexAction
     */
    public function testShouldGenerateAnsibleFileWithPeclRole()
    {
        $request = new \Symfony\Component\HttpFoundation\Request([
            'vmname'       => 'test',
            'peclpackages' => ['uploadprogress']
        ]);

        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->setMethods(['stream'])
            ->getMock();

        $path = __DIR__ . '/_assets/test';

        $app->expects($this->once())
            ->method('stream')
            ->with(
                $this->anything(),
                $this->equalTo(200)
            )
            ->will($this->returnCallback(function($callback, $status, $headers){
                return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, $status, $headers);
            }));

        $vagrantBundle = $this->getMockBuilder('\Phansible\Model\VagrantBundle')
            ->setMethods(['setRenderers', 'addRenderer', 'generateBundle'])
            ->getMock();

        $vagrantBundle->expects($this->once())
            ->method('setRenderers')
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(1))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\PlaybookRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(2))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\VagrantfileRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $vagrantBundle->expects($this->at(3))
            ->method('addRenderer')
            ->with(
                $this->isInstanceOf('\Phansible\Renderer\TemplateRenderer')
            )
            ->will($this->returnValue($vagrantBundle));

        $this->php->expects($this->once())
            ->method('time')
            ->will($this->returnValue(123));

        $this->php->expects($this->once())
            ->method('sys_get_temp_dir')
            ->will($this->returnValue('/tmp'));

        $this->php->expects($this->once())
            ->method('filesize')
            ->with('/tmp/bundle_123.zip')
            ->will($this->returnValue(1000));

        $roles = [
            'init',
            'php5-cli',
            'nginx',
            'php5-fpm',
            'phpcommon',
            'php-pecl',
            'app'
        ];

        $vagrantBundle->expects($this->once())
            ->method('generateBundle')
            ->with(
                $this->equalTo('/tmp/bundle_123.zip'),
                $roles
            )
            ->will($this->returnValue(1));

        $result = $this->controller
            ->setVagrantBundle($vagrantBundle)
            ->indexAction($request, $app);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\StreamedResponse', $result);
    }
}
