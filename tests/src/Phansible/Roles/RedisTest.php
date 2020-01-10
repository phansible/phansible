<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Redis();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Redis
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Redis::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Redis', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Redis::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('redis', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Redis::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('redis', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Redis::getInitialValues
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
