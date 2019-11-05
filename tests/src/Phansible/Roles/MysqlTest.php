<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class MysqlTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mysql($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Mysql
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Mysql::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('MySQL', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Mysql::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('mysql', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Mysql::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('mysql', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Mysql::getInitialValues
     */
    public function testShouldGetInitialValues()
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
