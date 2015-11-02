<?php

namespace Phansible\Roles;

class PgsqlTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Pgsql($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Pgsql
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Pgsql::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('PostgreSQL', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Pgsql::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('pgsql', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Pgsql::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('pgsql', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Pgsql::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0,
            'root_password' => 123,
            'databases' => [
                'name' => 'dbname',
                'user' => 'name',
                'password' => 123,
            ]
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
