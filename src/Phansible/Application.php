<?php

namespace Phansible;

use Phansible\Provider\RolesServiceProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Phansible
 */
class Application extends \Flint\Application
{
    /**
     * {@inheritdoc}
     */
    public function __construct($rootDir, $debug = false, array $parameters = [])
    {
        $parameters += ['config.cache_dir' => $rootDir . '/app/cache/config'];

        parent::__construct($rootDir, $debug, $parameters);
        $this->initialize();
    }

    /**
     * Initialize application
     */
    public function initialize()
    {
        $this->initProviders();

        $this->initRoles();

        if ($this['debug'] === false) {
            // Initialise the 'error' handler.
            $this->error([$this, 'errorHandler']);
        }
    }

    /**
     * Register service providers
     */
    protected function initProviders()
    {
        $this->register(new RolesServiceProvider());
    }

    /**
     * Initialize roles
     */
    protected function initRoles()
    {
        // Server settings
        $this['roles']->register(new Roles\Server($this));

        // Webservers
        $this['roles']->register(new Roles\Apache($this));
        $this['roles']->register(new Roles\Nginx($this));

        // Languages
        $this['roles']->register(new Roles\Hhvm($this));

        // Databases
        $this['roles']->register(new Roles\Mysql($this));
        $this['roles']->register(new Roles\Mariadb($this));
        $this['roles']->register(new Roles\Pgsql($this));

        // Deploy roles
        $this['roles']->register(new Roles\VagrantLocal($this));

        // PHP roles should always be last! this way we can detect other
        // roles and check if we need to add extra packages
        $this['roles']->register(new Roles\Php($this));
        $this['roles']->register(new Roles\Xdebug($this));
        $this['roles']->register(new Roles\Composer($this));
    }

    /**
     * Handle errors thrown in the application.
     *
     * @todo: according to the docs of flint it should handle exceptions, but for some reason it doesn't seem to work.
     *
     * @param  \Exception $exception
     * @return Response
     */
    public function errorHandler(\Exception $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
            $template = 'error.404.html.twig';
        } else {
            $template = 'error.html.twig';
        }
        return $this['twig']->render($template);

    }
}
