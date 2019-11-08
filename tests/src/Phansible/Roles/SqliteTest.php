<?php

namespace Phansible\Roles;

use Phansible\Application;
use Phansible\Role;
use PHPUnit\Framework\TestCase;

class SqliteTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Sqlite($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Sqlite
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Sqlite::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('SQLite', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Sqlite::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('sqlite', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Sqlite::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('sqlite', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Sqlite::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
