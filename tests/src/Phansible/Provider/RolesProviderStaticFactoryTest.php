<?php

namespace App\Phansible\Provider;

use App\Phansible\Role;
use App\Phansible\RolesManager;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class RolesProviderStaticFactoryTest extends TestCase
{
    /**
     * @var RolesProviderStaticFactory
     */
    private $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = RolesProviderStaticFactory::class;
    }

    public function testItShouldReturnARolesManager(): void
    {
        $rolesManager = $this->factory::create();

        $this->assertInstanceOf(RolesManager::class, $rolesManager);
    }

    public function testItShouldReturnAllTheExpectedRoles(): void
    {
        $rolesManager = $this->factory::create();

        $this->assertCount(20, $rolesManager->getRoles());
    }

    public function testItShouldRegisterRoles(): void
    {
        $role = $this->getRoleDouble();

        $rolesManager = $this->factory::create();
        $rolesManager->register($role);

        $this->assertCount(21, $rolesManager->getRoles());
    }

    /**
     * @return Stub
     */
    private function getRoleDouble(): Stub
    {
        return $this->createStub(Role::class);
    }

    public function tearDown(): void
    {
        unset(
            $this->factory,
        );

        parent::tearDown();
    }
}
