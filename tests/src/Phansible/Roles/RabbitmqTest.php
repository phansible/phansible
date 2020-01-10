<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class RabbitmqTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Rabbitmq();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Rabbitmq
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Rabbitmq::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('RabbitMQ', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Rabbitmq::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('rabbitmq', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Rabbitmq::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('rabbitmq', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Rabbitmq::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'  => 0,
            'plugins'  => [],
            'user'     => 'user',
            'password' => 'password',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
