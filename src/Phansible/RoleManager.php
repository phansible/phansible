<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

class RoleManager
{
    /**
     * @var \Phansible\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @param \Phansible\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register role
     * @param \Phansible\RoleInterface $role
     */
    public function register(RoleInterface $role)
    {
        $this->roles[] = $role;
    }

    /**
     * Get roles
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function setupRole(array $requestVars, VagrantBundle $vagrantBundle)
    {
        foreach ($this->roles as $role) {
            /** @var RoleInterface $role */
            $role->setup($requestVars, $vagrantBundle);
        }
    }

    /**
     * Get initial values for each role
     * @return array
     */
    public function getInitialValues()
    {
        $initials = [];
        foreach ($this->roles as $role) {
            $initials[$role->getSlug()] = $role->getInitialValues();
        }
        return $initials;
    }

    public function getAvailableOptions()
    {
        $available = [];
        foreach ($this->roles as $role) {
            $available[$role->getSlug()] = $role->getAvailableOptions();
        }
        return $available;
    }
}
