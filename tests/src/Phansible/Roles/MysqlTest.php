<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;
use Phansible\Application;
use Phansible\Role;

class MysqlTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mysql($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Mysql
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Mysql::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('MySQL', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Mysql::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mysql', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Mysql::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mysql', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Mysql::getInitialValues
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
