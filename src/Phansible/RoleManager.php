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
            if (array_key_exists($role->getSlug(), $requestVars)) {
                $role->setCustomData($requestVars[$role->getSlug()]);
            }
            $role->setup($vagrantBundle);
        }
    }

    /**
     * Get initial values for each role
     * @return array
     */
    public function getData($returnAvailableData = false)
    {
        $data = [];
        foreach ($this->roles as $role) {
            $data[$role->getSlug()] = $role->getData($returnAvailableData);
        }
        return $data;
    }
}
