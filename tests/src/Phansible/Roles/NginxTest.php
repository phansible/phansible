<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class NginxTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Nginx();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    #[covers(\App\Phansible\Roles\Nginx)]
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    #[covers(\App\Phansible\Roles\Nginx::getName)]
    public function testShouldGetName(): void
    {
        $this->assertEquals('Nginx', $this->role->getName());
    }

    #[covers(\App\Phansible\Roles\Nginx::getSlug)]
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('nginx', $this->role->getSlug());
    }

    #[covers(\App\Phansible\Roles\Nginx::getRole)]
    public function testShouldGetRole(): void
    {
        $this->assertEquals('nginx', $this->role->getRole());
    }

    #[covers(\App\Phansible\Roles\Nginx::getInitialValues)]
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'    => 1,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
