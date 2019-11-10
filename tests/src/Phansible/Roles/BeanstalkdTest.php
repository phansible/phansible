<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use PHPUnit\Framework\TestCase;
use App\Phansible\Application;

class BeanstalkdTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Beanstalkd($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Beanstalkd
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Beanstalkd::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('Beanstalkd', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Beanstalkd::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('beanstalkd', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Beanstalkd::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('beanstalkd', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Beanstalkd::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'       => 0,
            'listenAddress' => '0.0.0.0',
            'listenPort'    => '13000',
            'version'       => '1.10',
            'user'          => 'beanstalkd',
            'persistent'    => 'yes',
            'storage'       => '/var/lib/beanstalkd',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
