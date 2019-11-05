<?php

namespace Phansible\Roles;

use PHPUnit\Framework\TestCase;

class SolrTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Solr($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\Solr
     */
    public function testShouldInstanceOf()
    {
        $this->assertInstanceOf('\Phansible\Role', $this->role);
    }

    /**
     * @covers Phansible\Roles\Solr::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('Solr', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\Solr::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('solr', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\Solr::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('solr', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\Solr::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install' => 0,
            'port'    => '8983',
            'version' => '5.2.0',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
