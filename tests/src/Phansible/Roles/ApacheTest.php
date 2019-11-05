<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class ApacheTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Apache($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Apache
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Apache::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Apache', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Apache::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('apache', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Apache::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('apache', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Apache::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install'    => 0,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
