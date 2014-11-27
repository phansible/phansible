<?php

namespace Phansible\Provider;

use Phansible\Application;

class RolesServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Application(__DIR__);
        $app->register(new RolesServiceProvider());
        $app->boot();
        $this->assertInstanceOf('Phansible\RoleManager', $app['roles']);
    }
}
