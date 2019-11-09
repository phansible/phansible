<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;
use Phansible\Application;
use Phansible\Role;

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
     * @covers \Phansible\Roles\Pgsql
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Pgsql::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('PostgreSQL', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Pgsql::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('pgsql', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Pgsql::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('pgsql', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Pgsql::getInitialValues
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
