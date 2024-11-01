<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use App\Phansible\RoleWithDependencies;
use PHPUnit\Framework\TestCase;

class XdebugTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Xdebug();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    #[covers(\App\Phansible\Roles\Xdebug)]
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleWithDependencies::class, $this->role);
    }

    #[covers(\App\Phansible\Roles\Xdebug::getName)]
    public function testShouldGetName(): void
    {
        $this->assertEquals('XDebug', $this->role->getName());
    }

    #[covers(\App\Phansible\Roles\Xdebug::getSlug)]
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('xdebug', $this->role->getSlug());
    }

    #[covers(\App\Phansible\Roles\Xdebug::getRole)]
    public function testShouldGetRole(): void
    {
        $this->assertEquals('xdebug', $this->role->getRole());
    }

    #[covers(\App\Phansible\Roles\Xdebug::requiredRolesToBeInstalled)]
    public function testShouldGetRequiredRoles(): void
    {
        $expected = ['php'];

        $this->assertEquals($expected, $this->role->requiredRolesToBeInstalled());
    }

    #[covers(\App\Phansible\Roles\Xdebug::getInitialValues)]
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
