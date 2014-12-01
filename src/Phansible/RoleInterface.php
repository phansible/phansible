<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;

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
     * Get available options for the form
     *
     * @return array
     */
    public function getAvailableOptions();

    /**
     * Setup the role
     *
     * @param array $requestVars
     * @param \Phansible\Renderer\PlaybookRenderer $playbook
     * @param \Phansible\Renderer\VarfileRenderer $varFile
     * @throws \Exception
     */
    public function setup(array $requestVars, PlaybookRenderer $playbook, VarfileRenderer $varFile);

}
