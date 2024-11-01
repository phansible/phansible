<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class SqliteTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Sqlite();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    #[covers(\App\Phansible\Roles\Sqlite)]
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    #[covers(\App\Phansible\Roles\Sqlite::getName)]
    public function testShouldGetName(): void
    {
        $this->assertEquals('SQLite', $this->role->getName());
    }

    #[covers(\App\Phansible\Roles\Sqlite::getSlug)]
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('sqlite', $this->role->getSlug());
    }

    #[covers(\App\Phansible\Roles\Sqlite::getRole)]
    public function testShouldGetRole(): void
    {
        $this->assertEquals('sqlite', $this->role->getRole());
    }

    #[covers(\App\Phansible\Roles\Sqlite::getInitialValues)]
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
