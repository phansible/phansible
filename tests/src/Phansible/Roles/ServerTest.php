<?php

namespace App\Phansible\Roles;

use App\Phansible\Application;
use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Server($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Server
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Server::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Server', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Server::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('server', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Server::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('server', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Server::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'  => 1,
            'timezone' => 'UTC',
            'locale'   => 'en_US.UTF-8',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
