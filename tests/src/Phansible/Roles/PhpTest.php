<?php

namespace Phansible\Roles;

use Phansible\Application;
use Phansible\Role;
use PHPUnit\Framework\TestCase;
use Phansible\RoleValuesTransformer;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Model\VagrantBundle;

class PhpTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Php($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \Phansible\Roles\Php
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
        $this->assertInstanceOf(RoleValuesTransformer::class, $this->role);
    }

    /**
     * @covers \Phansible\Roles\Php::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('PHP', $this->role->getName());
    }

    /**
     * @covers \Phansible\Roles\Php::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('php', $this->role->getSlug());
    }

    /**
     * @covers \Phansible\Roles\Php::getRole
     */
    public function testShouldGetRole(): void
    {
        $this->assertEquals('php', $this->role->getRole());
    }

    /**
     * @covers \Phansible\Roles\Php::getInitialValues
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
     * @covers \Phansible\Roles\Php::transformValues
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
     * @covers \Phansible\Roles\Php::transformValues
     * @covers \Phansible\Roles\Php::addPhpPackage
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

        $playbook->expects($this->at(0))
            ->method('hasRole')
            ->willReturn(true);

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
