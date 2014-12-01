<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;

abstract class BaseRole implements RoleInterface
{
    protected $app;
    protected $name;
    protected $slug;
    protected $role;

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
            throw new \Exception('Role name has not been defined');
        }
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        if (!$this->slug) {
            throw new \Exception('Role slug has not been defined');
        }
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        if (!$this->role) {
            throw new \Exception('Role roles name has not been defined');
        }
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setup(
      array $requestVars,
      PlaybookRenderer $playbook,
      VarfileRenderer $varFile
    ) {
        if (!array_key_exists($this->getSlug(), $requestVars)) {
            return;
        }
        $config = $requestVars[$this->getSlug()];
        if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] === 0) {
            return;
        }
        $playbook->addRole($this->role);

        $varFile->addMultipleVars([$this->getSlug() => $config]);
    }

    /**
     * {@inheritdoc}
     */
    public abstract function getInitialValues();

    /**
     * {@inheritdoc}
     */
    public function getAvailableOptions()
    {
        return [];
    }
}
