<?php

namespace Phansible\Roles;

use Phansible\Application;
use Phansible\Role;
use PHPUnit\Framework\TestCase;

class ZookeeperTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Zookeeper($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Zookeeper
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Zookeeper::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Zookeeper', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Zookeeper::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('zookeeper', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Zookeeper::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('zookeeper', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Zookeeper::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Zookeeper($app);

        $expected = [
            'install' => 1,
            'port'    => '2181',
            'version' => '3.4.6',
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }
}
