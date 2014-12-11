<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;
use Exception;

abstract class BaseRole implements RoleInterface
{

    protected $name;
    protected $slug;
    protected $role;

    /**
     * @var \Phansible\Application
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if (!$this->name) {
            throw new Exception('Role name has not been defined');
        }
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        if (!$this->slug) {
            throw new Exception('Role slug has not been defined');
        }
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        if (!$this->role) {
            throw new Exception('Role roles name has not been defined');
        }
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        if (!array_key_exists($this->getSlug(), $requestVars)) {
            return;
        }
        if (!$this->installRole($requestVars)) {
            return;
        }
        $vagrantBundle->getPlaybook()->addRole($this->getRole());
        $config = $requestVars[$this->getSlug()];
        $vagrantBundle->getVarsFile()->addMultipleVars([$this->getSlug() => $config]);
    }

    /**
     * Check if we need to install the role based on the requestvars.
     *
     * @param array $requestVars
     * @param null|string $roleSlug
     * @return bool
     * @throws \Exception
     */
    protected function installRole(array $requestVars, $roleSlug = null)
    {
        if (is_null($roleSlug)) {
            $roleSlug = $this->getSlug();
        }

        if (!array_key_exists($roleSlug, $requestVars)) {
            return false;
        }

        $config = $requestVars[$roleSlug];
        /*
         * If the configuration doesn't have a section for this role
         * or if it'say not to install return false.
         */
        if (!is_array($config) ||
          !array_key_exists('install', $config) ||
          (!is_array($config['install']) && intval($config['install']) === 0)) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getInitialValues();

    /**
     * {@inheritdoc}
     */
    public function getAvailableOptions()
    {
        return [];
    }
}
