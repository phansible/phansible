<?php

namespace App\Phansible\Roles;

use PHPUnit\Framework\TestCase;
use App\Phansible\Application;
use App\Phansible\Role;

class ElasticSearchTest extends TestCase
{
    private $role;

    public function setUp(): void
    {
        $app = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->role = new ElasticSearch($app);
    }

    public function tearDown(): void
    {
        unset($this->role);
    }

    /**
     * @covers \App\Phansible\Roles\ElasticSearch
     */
    public function testShouldInstanceOf(): void
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    /**
     * @covers \App\Phansible\Roles\ElasticSearch::getName
     */
    public function testShouldGetName(): void
    {
        $this->assertEquals('ElasticSearch', $this->role->getName());
    }

    /**
     * @covers \App\Phansible\Roles\ElasticSearch::getSlug
     */
    public function testShouldGetSlug(): void
    {
        $this->assertEquals('elasticsearch', $this->role->getSlug());
    }

    /**
     * @covers \App\Phansible\Roles\ElasticSearch::getRole
     */
    public function testShouldGetRole()
    {
        $this->assertEquals('elasticsearch', $this->role->getRole());
    }

    /**
     * @covers \App\Phansible\Roles\ElasticSearch::getInitialValues
     */
    public function testShouldGetInitialValues(): void
    {
        $expected = [
            'install' => 0,
            'port'    => '9200',
            'version' => '1.5.2',
        ];

        $this->assertEquals($expected, $this->role->getInitialValues());
    }
}
