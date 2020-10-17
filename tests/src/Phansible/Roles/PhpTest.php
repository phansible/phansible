<?php

namespace App\Phansible\Roles;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\PlaybookRenderer;
use App\Phansible\Role;
use App\Phansible\RoleValuesTransformer;
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $this->role = new Php();
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Php
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleValuesTransformer::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\Php::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('PHP', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\Php::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('php', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\Php::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('php', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\Php::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install'      => 1,
            'packages'     => [
                'php5-cli',
                'php5-intl',
                'php5-mcrypt',
            ],
            'peclpackages' => [],
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    /**
     * @covers \App\Phansible\Roles\Php::transformValues
     */
    public function testShouldNotTransformValues(): void
    {
        $values = [
            'packages' => ['php5-cli', 'php5-intl'],
        ];

        $playbook = $this->getMockBuilder(PlaybookRenderer::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['hasRole'])
            ->getMock();

        $playbook->expects($this->any())
            ->method('hasRole')
            ->willReturn(false);

        $bundle = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getPlaybook'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('getPlaybook')
            ->willReturn($playbook);

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'packages' => [
                'php5-cli',
                'php5-intl',
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers \App\Phansible\Roles\Php::transformValues
     * @covers \App\Phansible\Roles\Php::addPhpPackage
     */
    public function testShouldTransformValues(): void
    {
        $values = [
            'packages' => ['php5-cli', 'php5-intl'],
        ];

        $playbook = $this->getMockBuilder(PlaybookRenderer::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['hasRole'])
            ->getMock();

          $playbook->method('hasRole')
            ->withConsecutive(['mysql'], ['mariadb'], ['pgsql'], ['sqlite'], ['mongodb'], ['php'])
            ->willReturnOnConsecutiveCalls(true, false, false, false, false, true);

        $bundle = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getPlaybook'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('getPlaybook')
            ->willReturn($playbook);

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'packages' => [
                'php5-cli',
                'php5-intl',
                'php5-mysql',
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
