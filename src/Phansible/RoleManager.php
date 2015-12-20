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
     * @param \Phansible\Role $role
     */
    public function register(Role $role)
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
     * Adds a role to bundle shipped to the user.
     *
     * @param  array         $requestVars   List of roles required
     * @param  VagrantBundle $vagrantBundle
     */
    public function setupRole(array $requestVars, VagrantBundle $vagrantBundle)
    {
        array_walk($this->roles, function (Role $role) use ($requestVars, $vagrantBundle) {
            if (! $this->willBeInstalled($role->getSlug(), $requestVars)) {
                return;
            }

            // Stop if the roles we rely on are not going to be installed.
            if ($role instanceof RoleWithDependencies) {
                foreach ($role->requiredRolesToBeInstalled() as $roleSlug) {
                    if (! $this->willBeInstalled($roleSlug, $requestVars)) {
                        return;
                    }
                }
            }

            $values = $requestVars[$role->getSlug()];

            if ($role instanceof RoleValuesTransformer) {
                $values = $role->transformValues($values, $vagrantBundle);
            }

            $vagrantBundle->getPlaybook()->addRole($role->getRole());
            $vagrantBundle->getVarsFile()->addMultipleVars([$role->getSlug() => $values]);
        });
    }

    /**
     * Checks if a given role will be installed.
     * Used to know if a cross dependency needs to be set up
     *
     * @param  string $roleSlug    The slug of the role
     * @param  array  $requestVars The information of the request
     * @return boolean
     */
    private function willBeInstalled($roleSlug, $requestVars)
    {
        if (!array_key_exists($roleSlug, $requestVars)) {
            return false;
        }

        $config = $requestVars[$roleSlug];

        if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] == 0) {
            return false;
        }

        return true;
    }
}
