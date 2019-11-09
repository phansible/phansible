<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;
use Phansible\Application;
use Phansible\Role;

class RedisTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Redis($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Redis
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Redis::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Redis', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Redis::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('redis', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Redis::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('redis', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Redis::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
            'port'    => 6379,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
