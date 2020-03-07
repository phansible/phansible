<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\RolesManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class BundleControllerTest extends TestCase
{
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $rolesManager = $this->getRolesManagerDouble();

        $this->controller = new BundleController($rolesManager);
    }

    /**
     * @covers \App\Phansible\Controller\BundleController::extractLocale
     */
    public function testShouldExtractLocale(): void
    {
        $result = $this->controller->extractLocale('en');

        $expected = 'en_US.UTF-8';

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers \App\Phansible\Controller\BundleController::extractLocale
     */
    public function testShouldExtractLocaleIfArray(): void
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
     * @covers \App\Phansible\Controller\BundleController::indexAction
     * @covers \App\Phansible\Controller\BundleController::getVagrantBundle
     * @covers \App\Phansible\Controller\BundleController::setVagrantBundle
     * @covers \App\Phansible\Controller\BundleController::getInventory
     */
    public function testShouldReturnResponseWithErrorMessage(): void
    {
        $data = [
            'vagrant_local' => [
                'vm' => [
                    'ip' => '',
                ],
            ],
        ];

        $request = new Request([], $data);

        $bundle = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['generateBundle'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('generateBundle')
            ->willReturn(false);

        $this->controller->setVagrantBundle($bundle);
        $response = $this->controller->indexAction($request);

        $this->assertEquals('An error occurred.', $response->getContent());
    }

    /**
     * @return MockObject
     */
    private function getRolesManagerDouble(): MockObject
    {
        return $this->getMockBuilder(RolesManager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setupRole'])
            ->getMock();
    }

    public function tearDown(): void
    {
        unset(
            $this->controller,
        );

        parent::tearDown();
    }
}
