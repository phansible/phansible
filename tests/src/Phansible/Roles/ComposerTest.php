<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use App\Phansible\RoleWithDependencies;
use PHPUnit\Framework\TestCase;

class ComposerTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Composer();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Composer
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleWithDependencies::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Composer::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Composer', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Composer::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('composer', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Composer::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('composer', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Composer::requiredRolesToBeInstalled
     */
    public function testShouldGetRequiredRoles(): void
    {
        $required = ['php'];
        $this->assertEquals($required, $this->role->requiredRolesToBeInstalled());
    }

    /**
     * @covers \App\Phansible\Roles\Composer::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
