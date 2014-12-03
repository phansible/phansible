<?php

namespace Phansible;

use Phansible\Roles\Composer;

class BaseRoleTest extends \PHPUnit_Framework_TestCase
{
    protected $role;

    public function setup()
    {
        $app = new Application('.');
        $this->role = new Composer($app);
    }

    public function testGetName()
    {
        $this->assertEquals('Composer', $this->role->getName());
    }

    public function testGetSlug()
    {
        $this->assertEquals('composer', $this->role->getSlug());
    }

    public function testGetRole()
    {
        $this->assertEquals('composer', $this->role->getRole());
    }

    public function testGetInitialValues()
    {
        $expected =  ['install' => 0];
        $this->assertEquals($expected, $this->role->getInitialValues());
    }

    public function testGetAvailableOptions()
    {
        $expected =  [];
        $this->assertEquals($expected, $this->role->getAvailableOptions());
    }
}
