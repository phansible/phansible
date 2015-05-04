<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

interface RoleInterface
{
    /**
     * Constructor
     *
     * @param \Phansible\Application $app
     */
    public function __construct(Application $app);

    /**
     * Get extension's English name, eg "Apache"
     *
     * @return string
     * @throws \Exception
     */
    public function getName();

    /**
     * Get url-friendly slug, eg "vagrantfile-local"
     *
     * @return string
     * @throws \Exception
     */
    public function getSlug();

    /**
     * Get role name, eg "php"
     *
     * @return string
     * @throws \Exception
     */
    public function getRole();

    /**
     * Get initial values for the form
     *
     * @return array
     */
    public function getInitialValues();

    /**
     * Setup the role
     *
     * @param array $requestVars
     * @param \Phansible\Model\VagrantBundle $vagrantBundle
     * @throws \Exception
     * @return void
     */
    public function setup(array $requestVars, VagrantBundle $vagrantBundle);
}
