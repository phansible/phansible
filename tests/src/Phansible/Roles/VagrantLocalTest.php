<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class VagrantLocalTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new VagrantLocal($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\VagrantLocal
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
        $this->assertInstanceOf('\Phansible\RoleValuesTransformer', $this->role);
    }

    /**
     * @covers Phansible\Roles\VagrantLocal::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Local', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\VagrantLocal::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('vagrant_local', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\VagrantLocal::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('vagrant_local', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\VagrantLocal::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    /**
     * @covers Phansible\Roles\VagrantLocal::transformValues
     * @covers Phansible\Roles\VagrantLocal::getVagrantFile
     * @covers Phansible\Roles\VagrantLocal::getBox
     */
    public function testShouldTransformValues()
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

        $bundle = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(['setVagrantFile'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('setVagrantFile')
            ->with(
                $this->isInstanceOf('Phansible\Renderer\VagrantfileRenderer')
            );

        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->setMethods(['offsetGet'])
            ->getMock();

        $app->expects($this->once())
            ->method('offsetGet')
            ->with('boxes')
            ->will($this->returnValue($boxes));

        $role = new VagrantLocal($app);

        $role->transformValues($values, $bundle);
    }
}
