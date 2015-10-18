<?php

namespace Phansible\Roles;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Server($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Server
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Server::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Server', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Server::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('server', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Server::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('server', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Server::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 1,
            'timezone' => 'UTC',
            'locale' => 'en_US.UTF-8',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
