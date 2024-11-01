<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;

class MongodbTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Mongodb();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    #[covers(\App\Phansible\Roles\Mongodb)]
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    #[covers(\App\Phansible\Roles\Mongodb::getName)]
    public function testShouldGetName(): void
    {
        $this->assertEquals('MongoDb', $this->role->getName());
    }

    #[covers(\App\Phansible\Roles\Mongodb::getSlug)]
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('mongodb', $this->role->getSlug());
    }

    #[covers(\App\Phansible\Roles\Mongodb::getRole)]
    public function testShouldGetRole(): void
    {
        $this->assertEquals('mongodb', $this->role->getRole());
    }

    #[covers(\App\Phansible\Roles\Mongodb::getInitialValues)]
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
