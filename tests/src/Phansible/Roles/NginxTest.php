<?php

namespace Phansible\Roles;

class NginxTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Nginx($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Nginx
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Nginx::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Nginx', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Nginx::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('nginx', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Nginx::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('nginx', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Nginx::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 1,
            'docroot' => '/vagrant',
            'servername' => 'myApp.vb'
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
