<?php

namespace Phansible\Provider;

use Phansible\RoleManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RolesServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app): void
    {
        $app['roles'] = static function () {
            return new RoleManager();
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app): void
    {
    }
}
