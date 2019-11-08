<?php

namespace Phansible\Provider;

use Phansible\Application;
use PHPUnit\Framework\TestCase;
use Phansible\RoleManager;

class RolesServiceProviderTest extends TestCase
{
    public function testRegister(): void
    {
        $app = new Application(__DIR__ . '../');
        $app->register(new RolesServiceProvider());
        $app->boot();
        $this->assertInstanceOf(RoleManager::class, $app['roles']);
    }
}
