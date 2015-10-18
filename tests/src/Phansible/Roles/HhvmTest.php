<?php

namespace Phansible\Roles;

class HhvmTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Hhvm($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Hhvm
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Hhvm::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('HHVM', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Hhvm::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('hhvm', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Hhvm::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('hhvm', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Hhvm::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0,
            'host' => '127.0.0.1',
            'port' => 9000,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
