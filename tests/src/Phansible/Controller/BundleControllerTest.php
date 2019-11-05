<?php

namespace Phansible\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class BundleControllerTest extends TestCase
{
    /**
     * @var Phansible\Controller\BundleController
     */
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new BundleController();
    }

    /**
     * @covers Phansible\Controller\BundleController::extractLocale
     */
    public function testShouldExtractLocale()
    {
        $result = $this->controller->extractLocale('en');

        $expected = 'en_US.UTF-8';

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers Phansible\Controller\BundleController::extractLocale
     */
    public function testShouldExtractLocaleIfArray()
    {
        $langs = [
            'en_US',
            'en',
        ];

        $result = $this->controller->extractLocale($langs);

        $expected = 'en_US.UTF-8';

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers Phansible\Controller\BundleController::indexAction
     * @covers Phansible\Controller\BundleController::getVagrantBundle
     * @covers Phansible\Controller\BundleController::setVagrantBundle
     * @covers Phansible\Controller\BundleController::getInventory
     */
    public function testShouldResponseWithErrorMessage()
    {
        $data = [
            'vagrant_local' => [
                'vm' => [
                    'ip' => '',
                ],
            ],
        ];

        $request = new Request([], $data);

        $roles = $this->createMock('Phansible\RoleManager');

        $app = $this->getMockBuilder('Phansible\Application')
            ->disableOriginalConstructor()
            ->setMethods(['offsetGet'])
            ->getMock();

        $app->expects($this->once())
            ->method('offsetGet')
            ->with('roles')
            ->will($this->returnValue($roles));

        $bundle = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(['generateBundle'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('generateBundle')
            ->will($this->returnValue(false));

        $this->controller->setVagrantBundle($bundle);
        $response = $this->controller->indexAction($request, $app);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals('An error occurred.', $response->getContent());
    }
}
