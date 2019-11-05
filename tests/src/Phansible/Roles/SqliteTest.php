<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class SqliteTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Sqlite($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Sqlite
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Sqlite::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('SQLite', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Sqlite::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('sqlite', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Sqlite::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('sqlite', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Sqlite::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
