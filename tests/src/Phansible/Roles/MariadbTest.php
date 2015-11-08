<?php

namespace Phansible\Roles;

class MariadbTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mariadb($app);
    }

    public function tearDown()
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
            'install' => 0,
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
     * @covers Phansible\Roles\Mariadb::transformValues
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
