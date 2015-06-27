<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

class RoleManager
{
    /**
     * @var array
     */
    protected $roles = [];

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

    /**
     * {@inheritdoc}
     */
    public function setupRole(array $requestVars, VagrantBundle $vagrantBundle)
    {
        array_walk($this->roles, function(RoleInterface $role) use($requestVars, $vagrantBundle) {
            if (!array_key_exists($role->getSlug(), $requestVars)) {
                return;
            }

            $config = $requestVars[$role->getSlug()];

            if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] == 0) {
                return;
            }

            $vagrantBundle->getPlaybook()->addRole($role->getRole());
            $vagrantBundle->getVarsFile()->addMultipleVars([$role->getSlug() => $config]);

            $role->setup($requestVars, $vagrantBundle);
        });
    }
}
