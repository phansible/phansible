<?php

namespace Phansible\Roles;

use Phansible\Role;
use PHPUnit\Framework\TestCase;
use Phansible\Application;

class MongodbTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Mongodb($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Mongodb
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Mongodb::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('MongoDb', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Mongodb::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mongodb', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Mongodb::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mongodb', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Mongodb::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
