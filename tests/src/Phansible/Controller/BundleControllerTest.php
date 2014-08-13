<?php
/**
 * BundleController Test
 */

namespace Phansible\Controller;

class BundleControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $twig;
    private $config;

    public function setUp()
    {
        parent::setUp();

        $this->controller = new BundleController();
        $this->twig       = $this->getMockBuilder('\Twig_Environment')
            ->setMethods(['render'])
            ->getMock();

        $this->config = [
            'webservers' => [
                'nginxphp' => [
                    'name' => 'NGINX + PHP5-FPM',
                    'include' => [ 'nginx', 'php5-fpm' ]
                ]
            ],
            'boxes' => [
                'precise32' => [
                    'name'  => 'Ubuntu Precise Pangolin (12.04) 32',
                    'url'   => 'http://files.vagrantup.com/precise32.box'
                ],
                'precise64' => [
                    'name'  => 'Ubuntu Precise Pangolin (12.04) 64',
                    'url'   => 'http://files.vagrantup.com/precise64.box'
                ],
            ]
        ];
    }

    public function tearDown()
    {
        $this->controller = null;
        $this->twig = null;
    }

    /**
     * @covers \Phansible\Controller\BundleController::getWebServer
     */
    public function testGetWebServer()
    {
        $container = new \Pimple();
        $container['config'] = $this->config;

        $this->controller->setPimple($container);
        $webserver = $this->controller->getWebServer('nginxphp');

        $this->assertArrayHasKey('name', $webserver);
    }

    /**
     * @covers \Phansible\Controller\BundleController::getBox
     */
    public function testGetBox()
    {
        $container = new \Pimple();
        $container['config'] = $this->config;

        $this->controller->setPimple($container);
        $box = $this->controller->getBox('precise64');

        $this->assertArrayHasKey('name', $box);
        $this->assertEquals('http://files.vagrantup.com/precise64.box', $box['url']);
    }
}
 