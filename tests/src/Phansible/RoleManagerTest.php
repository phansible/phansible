<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;
use PHPUnit\Framework\TestCase;
use Phansible\Role;

class RoleManagerTest extends TestCase
{
    protected $roleManager;

    public function setup(): void
    {
        $this->roleManager = new RoleManager();
    }

    public function testThatRegisterAddsTheGivenRoleToTheListOfRoles(): void
    {
        $registeredRole = $this->getMockBuilder(Role::class)
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

    public function DisableForNowtestThatOurRolesAreBeingSetUp(): void
    {
        $firstRole = $this->getMockBuilder(Role::class)
            ->disableOriginalConstructor()
            ->getMock();

        $firstRole->expects($this->once())
            ->method('setup');

        $secondRole = $this->getMockBuilder(Role::class)
            ->disableOriginalConstructor()
            ->getMock();

        $secondRole->expects($this->once())
            ->method('setup');

        $this->roleManager->register($firstRole);
        $this->roleManager->register($secondRole);

        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->roleManager->setupRole(['a list of valid variables'], new VagrantBundle('path/to/ansible', $twig));
    }

    public function testWeAreAbleToRetrieveRolesInitialValues(): void
    {
        $role = $this->getMockBuilder(Role::class)
            ->disableOriginalConstructor()
            ->getMock();

        $role->expects($this->any())
            ->method('getSlug')
            ->willReturn('MySlug');

        $role->expects($this->any())
            ->method('getInitialValues')
            ->willReturn(['default values']);

        $this->roleManager->register($role);

        $this->assertSame(
            ['MySlug' => ['default values']],
            $this->roleManager->getInitialValues()
        );
    }
}
