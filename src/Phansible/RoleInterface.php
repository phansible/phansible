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
     * Get initial values for the form
     *
     * @return array
     */
    public function getInitialValues();
}
