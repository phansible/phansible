<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

class RoleManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $roleManager;

    public function setup()
    {
        $this->roleManager = new RoleManager();
    }

    public function testThatRegisterAddsTheGivenRoleToTheListOfRoles()
    {
        $registeredRole = $this->getMockBuilder('Phansible\RoleInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->roleManager->register($registeredRole);

        $this->assertCount(1, $this->roleManager->getRoles());
        $this->assertSame(
            $registeredRole,
            $this->roleManager->getRoles()[0],
            'We should get the same instance of the given Composer role'
        );
    }

    public function DisableForNowtestThatOurRolesAreBeingSetUp()
    {
        $firstRole = $this->getMockBuilder('Phansible\RoleInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $firstRole->expects($this->once())
            ->method('setup');

        $secondRole = $this->getMockBuilder('Phansible\RoleInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $secondRole->expects($this->once())
            ->method('setup');

        $this->roleManager->register($firstRole);
        $this->roleManager->register($secondRole);

        $twig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $this->roleManager->setupRole(['a list of valid variables'], new VagrantBundle('path/to/ansible', $twig));
    }

    public function testWeAreAbleToRetrieveRolesInitialValues()
    {
        $role = $this->getMockBuilder('Phansible\RoleInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $role->expects($this->any())
            ->method('getSlug')
            ->will($this->returnValue('MySlug'));

        $role->expects($this->any())
            ->method('getInitialValues')
            ->will($this->returnValue(['default values']));

        $this->roleManager->register($role);

        $this->assertSame(
            ['MySlug' => ['default values']],
            $this->roleManager->getInitialValues()
        );
    }
}
