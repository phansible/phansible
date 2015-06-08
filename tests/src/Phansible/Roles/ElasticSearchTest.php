<?php

namespace Phansible\Roles;

class ElasticSearchTest extends \PHPUnit_Framework_TestCase
{
    private $role;

    public function setUp()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new ElasticSearch($app);
    }

    public function tearDown()
    {
        unset($this->role);
    }

    /**
     * @covers Phansible\Roles\ElasticSearch::getName
     */
    public function testShouldGetName()
    {
        $this->assertEquals('ElasticSearch', $this->role->getName());
    }

    /**
     * @covers Phansible\Roles\ElasticSearch::getSlug
     */
    public function testShouldGetSlug()
    {
        $this->assertEquals('elasticsearch', $this->role->getSlug());
    }

    /**
     * @covers Phansible\Roles\ElasticSearch::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('elasticsearch', $this->role->getRole());
    }

    /**
     * @covers Phansible\Roles\ElasticSearch::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $expected = [
            'install'   => 0,
            'port'      => '9200',
            'version'   => '1.5.2'
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
