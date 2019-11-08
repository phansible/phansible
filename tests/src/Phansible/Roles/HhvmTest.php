<?php

namespace Phansible\Roles;

use Phansible\Role;
use PHPUnit\Framework\TestCase;
use Phansible\Application;

class HhvmTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Hhvm($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Hhvm
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Hhvm::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('HHVM', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Hhvm::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('hhvm', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Hhvm::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('hhvm', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Hhvm::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
            'host'    => '127.0.0.1',
            'port'    => 9000,
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
