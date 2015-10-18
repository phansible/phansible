<?php

namespace Phansible\Roles;

class XdebugTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Xdebug($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Xdebug
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
        $this->assertInstanceOf('\Phansible\RoleWithDependencies', $this->role);
    }

    /**
     * @covers Phansible\Roles\Xdebug::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('XDebug', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Xdebug::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('xdebug', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Xdebug::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('xdebug', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Xdebug::requiredRolesToBeInstalled
     */
    public function testShouldGetRequiredRoles()
    {
        $expected = ['php'];

        $this->assertEquals($expected, $this->role->requiredRolesToBeInstalled());
    }

    /**
     * @covers Phansible\Roles\Xdebug::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install'   => 0
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
