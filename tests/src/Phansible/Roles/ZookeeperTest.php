<?php

namespace Phansible\Roles;

use Phansible\RoleManager;

class ZookeeperTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Zookeeper($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Zookeeper
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Zookeeper::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Zookeeper', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Zookeeper::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('zookeeper', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Zookeeper::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('zookeeper', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Zookeeper::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Zookeeper($app);

        $expected = [
            'install'   => 1,
            'port'      => '2181',
            'version'   => '3.4.6'
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }
}
