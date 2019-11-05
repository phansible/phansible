<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class MariadbTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mariadb($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Mariadb
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Mariadb::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('MariaDb', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Mariadb::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('mariadb', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Mariadb::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('mariadb', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Mariadb::getInitialValues
     */
    public function testShouldGetInitialValues()
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
