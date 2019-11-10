<?php

namespace App\Phansible\Roles;

use PHPUnit\Framework\TestCase;
use App\Phansible\Application;
use App\Phansible\Role;

class PgsqlTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Pgsql($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Pgsql
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Pgsql::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('PostgreSQL', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Pgsql::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('pgsql', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Pgsql::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('pgsql', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Pgsql::getInitialValues
     */
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
