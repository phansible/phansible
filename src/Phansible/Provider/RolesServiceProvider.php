<?php

namespace Phansible\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Phansible\RoleManager;

class RolesServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['roles'] = $app->share(
            function ($app) {
                return new RoleManager();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
