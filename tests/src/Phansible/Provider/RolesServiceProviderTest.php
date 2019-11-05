<?php

namespace Phansible\Provider;

use Phansible\Application;
use PHPUnit\Framework\TestCase;

class RolesServiceProviderTest extends TestCase
{
    public function testRegister()
    {
        $app = new Application(__DIR__ . '../');
        $app->register(new RolesServiceProvider());
        $app->boot();
        $this->assertInstanceOf('Phansible\RoleManager', $app['roles']);
    }
}
