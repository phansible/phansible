<?php

namespace Phansible\Roles;

class SolrTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new Solr($app);
    }

    public function tearDown()
    {
        unset($this->role);
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

        $role = new Solr($app);

        $expected = [
            'install'   => 0,
            'port'      => '8983',
            'version'   => '5.2.0'
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }
}
