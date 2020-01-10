<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class ZookeeperTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Zookeeper();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Zookeeper
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Zookeeper::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Zookeeper', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Zookeeper::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('zookeeper', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Zookeeper::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('zookeeper', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Zookeeper::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
//        $app = $this->getMockBuilder(Application::class)
//            ->disableOriginalConstructor()
//            ->getMock();

        $role = new Zookeeper();

        $expected = [
            'install' => 1,
            'port'    => '2181',
            'version' => '3.4.6',
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }
}
