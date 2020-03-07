<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class MysqlTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Mysql();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Mysql
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Mysql::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('MySQL', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Mysql::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mysql', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Mysql::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mysql', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Mysql::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'       => 1,
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
