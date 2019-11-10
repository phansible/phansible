<?php

namespace App\Phansible;

use Exception;
use App\Phansible\Provider\GithubProvider;
use App\Phansible\Provider\RolesServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @package Phansible
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Application extends \Flint\Application
{
    /**
     * {@inheritdoc}
     */
    public function __construct($rootDir, $debug = false, array $parameters = [])
    {
        parent::__construct($rootDir, $debug, $parameters);
        $this->initialize();
    }

    /**
     * Initialize application
     */
    public function initialize(): void
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
    protected function initProviders(): void
    {
        $this->register(new RolesServiceProvider());
        $this->register(new GithubProvider());
    }

    /**
     * Initialize roles
     */
    protected function initRoles(): void
    {
        // Server settings
        $this['roles']->register(new Roles\Server());

        // Deploy roles
        $this['roles']->register(new Roles\VagrantLocal($this));

        // Webservers
        $this['roles']->register(new Roles\Apache());
        $this['roles']->register(new Roles\Nginx());

        // Languages
        $this['roles']->register(new Roles\Hhvm());

        // Databases
        $this['roles']->register(new Roles\Mysql());
        $this['roles']->register(new Roles\Mariadb());
        $this['roles']->register(new Roles\Pgsql());
        $this['roles']->register(new Roles\Mongodb());
        $this['roles']->register(new Roles\Sqlite());
        $this['roles']->register(new Roles\Redis());

        //Workers
        $this['roles']->register(new Roles\Rabbitmq());
        $this['roles']->register(new Roles\Beanstalkd());

        // Only if Solr cloud mode is enabled
        $this['roles']->register(new Roles\Zookeeper());

        // Search Engines
        $this['roles']->register(new Roles\Solr());
        $this['roles']->register(new Roles\ElasticSearch());

        // PHP roles should always be last! this way we can detect other
        // roles and check if we need to add extra packages
        $this['roles']->register(new Roles\Php());
        $this['roles']->register(new Roles\Xdebug());
        $this['roles']->register(new Roles\Composer());
        $this['roles']->register(new Roles\Blackfire());
    }

    /**
     * Handle errors thrown in the application.
     *
     * @todo: according to the docs of flint it should handle exceptions, but for some reason it doesn't seem to work.
     *
     * @param Exception $exception
     * @return Response
     */
    public function errorHandler(Exception $exception): Response
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() === 404) {
            $template = 'error.404.html.twig';
        } else {
            $template = 'error.html.twig';
        }

        return $this['twig']->render($template);

    }
}
