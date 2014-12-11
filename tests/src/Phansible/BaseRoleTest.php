<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;
use Exception;

class BaseRoleTest extends \PHPUnit_Framework_TestCase
{
    protected $role;

    public function setup()
    {
        $app = new Application('.');
        $this->role = $this->getMockForAbstractClass('Phansible\BaseRole', [$app]);
    }

    /**
     * @expectedException Exception
     */
    public function testGetName()
    {
       $this->role->getName();
    }

    /**
     * @expectedException Exception
     */
    public function testGetSlug()
    {
        $this->role->getSlug();
    }

    /**
     * @expectedException Exception
     */
    public function testGetRole()
    {
        $this->role->getRole();
    }

    /**
     * @expectedException Exception
     */
    public function testSetup()
    {
        $vagrantBundle = new VagrantBundle('.');
        $this->role->setup([], $vagrantBundle);
    }


    public function testGetAvailableOptions()
    {
        $expected = [];
        $this->assertEquals($expected, $this->role->getAvailableOptions());
    }
}
