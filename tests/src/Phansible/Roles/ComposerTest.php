<?php

namespace Phansible\Roles;

class ComposerTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Composer($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Composer
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
        $this->assertInstanceOf('\Phansible\RoleWithDependencies', $this->role);
    }

    /**
     * @covers Phansible\Roles\Composer::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Composer', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Composer::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('composer', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Composer::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('composer', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Composer::requiredRolesToBeInstalled
     */
    public function testShouldGetRequiredRoles()
    {
        $required = ['php'];
        $this->assertEquals($required, $this->role->requiredRolesToBeInstalled());
    }

    /**
     * @covers Phansible\Roles\Composer::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
