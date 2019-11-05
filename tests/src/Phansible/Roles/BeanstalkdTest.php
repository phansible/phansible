<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class BeanstalkdTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Beanstalkd($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Beanstalkd
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Beanstalkd::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Beanstalkd', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Beanstalkd::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('beanstalkd', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Beanstalkd::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('beanstalkd', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Beanstalkd::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install'       => 0,
            'listenAddress' => '0.0.0.0',
            'listenPort'    => '13000',
            'version'       => '1.10',
            'user'          => 'beanstalkd',
            'persistent'    => 'yes',
            'storage'       => '/var/lib/beanstalkd',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
