<?php

namespace App\Phansible\Roles;

use App\Phansible\Application;
use App\Phansible\Role;
use PHPUnit\Framework\TestCase;
use App\Phansible\RoleValuesTransformer;
use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\VagrantfileRenderer;

class VagrantLocalTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new VagrantLocal($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleValuesTransformer::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Local', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('vagrant_local', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('vagrant_local', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    /**
     * @covers \App\Phansible\Roles\VagrantLocal::transformValues
     * @covers \App\Phansible\Roles\VagrantLocal::getVagrantFile
     * @covers \App\Phansible\Roles\VagrantLocal::getBox
     */
    public function testShouldTransformValues(): void
    {
        $values = [
            'vm' => [
                'base_box'     => 'trusty64',
                'hostname'     => 'default',
                'ip'           => '192.168.33.99',
                'memory'       => '512',
                'sharedfolder' => './',
                'mountPoint'   => '/vagrant',
                'syncType'     => 'nfs',
            ],
        ];

        $boxes = [
            'virtualbox' => [
                'trusty64' => [
                    'cloud' => 'ubuntu/trusty64',
                    'url'   => 'http://local.trusty64',
                ],
            ],
        ];

        $bundle = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setVagrantFile'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('setVagrantFile')
            ->with(
                $this->isInstanceOf(VagrantfileRenderer::class)
            );

        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['offsetGet'])
            ->getMock();

        $app->expects($this->once())
            ->method('offsetGet')
            ->with('boxes')
            ->willReturn($boxes);

        $role = new VagrantLocal($app);

        $role->transformValues($values, $bundle);
    }
}
