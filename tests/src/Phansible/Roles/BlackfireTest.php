<?php

namespace Phansible\Roles;

use Phansible\Role;
use PHPUnit\Framework\TestCase;
use Phansible\Application;

class BlackfireTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Blackfire($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Blackfire
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Blackfire::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Blackfire', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Blackfire::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('blackfire', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Blackfire::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('blackfire', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Blackfire::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'      => 0,
            'server_id'    => '',
            'server_token' => '',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
