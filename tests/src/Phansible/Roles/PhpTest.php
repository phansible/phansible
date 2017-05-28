<?php

namespace Phansible\Roles;

class PhpTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Php($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Php
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
        $this->assertInstanceOf('\Phansible\RoleValuesTransformer', $this->role);
    }

    /**
     * @covers Phansible\Roles\Php::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('PHP', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Php::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('php', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Php::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('php', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Php::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 1,
            'packages' => [
                'php5.6-cli',
                'php5.6-intl',
                'php5.6-mcrypt',
            ],
            'peclpackages' => []
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    /**
     * @covers Phansible\Roles\Php::transformValues
     */
    public function testShouldNotTransformValues()
    {
        $values = [
            'packages' => ['php5.5-cli', 'php5.5-intl'],
            'php_version' => '5.5'
        ];

        $playbook = $this->getMockBuilder('Phansible\Renderer\PlaybookRenderer')
            ->disableOriginalConstructor()
            ->setMethods(['hasRole'])
            ->getMock();

        $playbook->expects($this->any())
            ->method('hasRole')
            ->will($this->returnValue(false));

        $bundle = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(['getPlaybook'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('getPlaybook')
            ->will($this->returnValue($playbook));

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'packages' => [
                'php5.5-cli',
                'php5.5-intl'
            ],
            'php_version' => '5.5'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers Phansible\Roles\Php::transformValues
     * @covers Phansible\Roles\Php::addPhpPackage
     */
    public function testShouldTransformValues()
    {
        $values = [
            'packages' => ['php5.6-cli', 'php5.6-intl'],
            'php_version' => '5.6'
        ];

        $playbook = $this->getMockBuilder('Phansible\Renderer\PlaybookRenderer')
            ->disableOriginalConstructor()
            ->setMethods(['hasRole'])
            ->getMock();

        $playbook->expects($this->at(0))
            ->method('hasRole')
            ->will($this->returnValue(true));

        $bundle = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(['getPlaybook'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('getPlaybook')
            ->will($this->returnValue($playbook));

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'packages' => [
                'php5.6-cli',
                'php5.6-intl',
                'php5.6-mysql'
            ],
            'php_version' => '5.6'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers Phansible\Roles\Php::transformValues
     * @covers Phansible\Roles\Php::addPhpPackage
     */
    public function testShouldTransformValuesPhp7()
    {
        $values = [
            'packages' => ['php7.0-cli', 'php7.0-intl'],
            'php_version' => '7.0'
        ];

        $playbook = $this->getMockBuilder('Phansible\Renderer\PlaybookRenderer')
            ->disableOriginalConstructor()
            ->setMethods(['hasRole'])
            ->getMock();

        $playbook->expects($this->at(0))
            ->method('hasRole')
            ->will($this->returnValue(true));

        $bundle = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(['getPlaybook'])
            ->getMock();

        $bundle->expects($this->once())
            ->method('getPlaybook')
            ->will($this->returnValue($playbook));

        $result = $this->role->transformValues($values, $bundle);

        $expected = [
            'packages' => [
                'php7.0-cli',
                'php7.0-intl',
                'php7.0-mysql'
            ],
            'php_version' => '7.0'
        ];

        $this->assertEquals($expected, $result);
    }
}
