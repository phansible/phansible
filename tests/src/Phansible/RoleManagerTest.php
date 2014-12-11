<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Phansible\Roles\Composer;
use Phansible\Roles\Xdebug;
use Phansible\Roles\Hhvm;

class RoleManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $roleManager;
    protected $app;

    public function setup()
    {
        $this->app = new Application(__DIR__ . '../');
        $this->roleManager = new RoleManager();
    }

    public function testRegisterRoles()
    {
        $expectedRole = new Composer($this->app);
        $this->roleManager->register($expectedRole);
        $roles = $this->roleManager->getRoles();
        $this->assertTrue(count($roles) == 1);
        if (count($roles)) {
            $role = $roles[0];
            $this->assertTrue($role === $expectedRole);
        }
    }

    public function testSetupRoles()
    {
        $vagrantBundle = new VagrantBundle();
        $vagrantBundle->setPlaybook(new PlaybookRenderer());
        $vagrantBundle->setVarsFile(new VarfileRenderer('all'));
        $requestVars = ['composer' => ['install' => 1], 'xdebug' => ['install' => 0]];
        $this->roleManager->register(new Composer($this->app));
        $this->roleManager->register(new Xdebug($this->app));
        $this->roleManager->register(new Hhvm($this->app));
        $this->roleManager->setupRole($requestVars, $vagrantBundle);

        $this->assertTrue($vagrantBundle->getPlaybook()->hasRole('composer'));
        $this->assertFalse($vagrantBundle->getPlaybook()->hasRole('xdebug'));
        $this->assertFalse($vagrantBundle->getPlaybook()->hasRole('hhvm'));
    }

    public function testGetInitialValues()
    {
        $vagrantBundle = new VagrantBundle();
        $vagrantBundle->setPlaybook(new PlaybookRenderer());
        $vagrantBundle->setVarsFile(new VarfileRenderer('all'));
        $requestVars = ['composer' => ['install' => 1]];
        $this->roleManager->register(new Composer($this->app));
        $this->roleManager->setupRole($requestVars, $vagrantBundle);
        $initialValues = $this->roleManager->getInitialValues();
        $expectedValues = ['composer' => ['install' => 0]];
        $this->assertEquals($expectedValues, $initialValues);
    }

    public function testGetAvailableOptions()
    {
        $vagrantBundle = new VagrantBundle();
        $vagrantBundle->setPlaybook(new PlaybookRenderer());
        $vagrantBundle->setVarsFile(new VarfileRenderer('all'));
        $requestVars = ['composer' => ['install' => 1]];
        $this->roleManager->register(new Composer($this->app));
        $this->roleManager->setupRole($requestVars, $vagrantBundle);
        $initialValues = $this->roleManager->getAvailableOptions();
        $expectedValues = ['composer' => []];
        $this->assertEquals($expectedValues, $initialValues);
    }
}
