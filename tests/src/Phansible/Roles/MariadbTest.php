<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class MariadbTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Mariadb();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    #[covers(\App\Phansible\Roles\Mariadb)]
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    #[covers(\App\Phansible\Roles\Mariadb::getName)]
    public function testShouldGetName(): void
    {
        $this->assertEquals('MariaDb', $this->role->getName());
    }

    #[covers(\App\Phansible\Roles\Mariadb::getSlug)]
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mariadb', $this->role->getSlug());
    }

    #[covers(\App\Phansible\Roles\Mariadb::getRole)]
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mariadb', $this->role->getRole());
    }

    #[covers(\App\Phansible\Roles\Mariadb::getInitialValues)]
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'       => 0,
            'root_password' => 123,
            'databases'     => [
                'name'     => 'dbname',
                'user'     => 'name',
                'password' => 123,
            ],
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
