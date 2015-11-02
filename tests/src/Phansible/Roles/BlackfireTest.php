<?php

namespace Phansible\Roles;

class BlackfireTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Blackfire($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Blackfire
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Blackfire::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Blackfire', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Blackfire::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('blackfire', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Blackfire::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('blackfire', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Blackfire::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0,
            'server_id' => '',
            'server_token' => '',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
