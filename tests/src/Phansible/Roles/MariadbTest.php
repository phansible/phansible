<?php

namespace Phansible\Roles;

use Phansible\Role;
use PHPUnit\Framework\TestCase;
use Phansible\Application;

class MariadbTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mariadb($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Mariadb
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Mariadb::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('MariaDb', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Mariadb::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mariadb', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Mariadb::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mariadb', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Mariadb::getInitialValues
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
