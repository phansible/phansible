<?php

namespace Phansible\Roles;

class MysqlTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mysql($app);
    }

    public function tearDown()
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
            'dump'          => '',
            'users'         => [
                [
                    'user'      => 'user',
                    'password'  => 'password'
                ]
            ]
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    /**
     * @covers Phansible\Roles\Mysql::transformValues
     */
    public function testShoulTransformValues()
    {
        $values = [
            'users' => [
                0 => ['user' => 'user', 'password' => 'password'],
                4 => ['user' => 'user', 'password' => 'password'],
                7 => ['user' => 'user', 'password' => 'password']
            ]
        ];

        $bundle = $this->getMockBuilder('\Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'users' => [
                ['user' => 'user', 'password' => 'password'],
                ['user' => 'user', 'password' => 'password'],
                ['user' => 'user', 'password' => 'password']
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}
