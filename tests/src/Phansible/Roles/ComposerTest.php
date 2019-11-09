<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;
use Phansible\Application;
use Phansible\Role;
use Phansible\RoleWithDependencies;

class ComposerTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Composer($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Composer
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleWithDependencies::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Composer::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Composer', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Composer::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('composer', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Composer::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('composer', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Composer::requiredRolesToBeInstalled
     */
    public function testShouldGetRequiredRoles(): void
    {
        $required = ['php'];
        $this->assertEquals($required, $this->role->requiredRolesToBeInstalled());
    }

    /**
     * @covers \Phansible\Roles\Composer::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
