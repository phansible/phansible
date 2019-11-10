<?php

namespace App\Phansible\Provider;

use App\Phansible\Application;
use PHPUnit\Framework\TestCase;
use App\Phansible\RoleManager;

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
