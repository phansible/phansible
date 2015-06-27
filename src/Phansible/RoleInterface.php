<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

interface RoleInterface
{
    /**
     * Get extension's English name, eg "Apache"
     *
     * @return string
     */
    public function getName();

    /**
     * Get url-friendly slug, eg "vagrantfile-local"
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get role name, eg "php"
     *
     * @return string
     */
    public function getRole();

    /**
     * Set a list of roles slugs that this role depends on.
     * If any of this roles is not installed we will not add this one.
     *
     * @return array The list of slug roles that should be installed
     */
    public function requiresRoles();

    /**
     * Get initial values for the form
     *
     * @return array
     */
    public function getInitialValues();
}
