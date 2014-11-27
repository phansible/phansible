<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Symfony\Component\HttpFoundation\Request;

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
     * Initialize roles
     */
    public function initialize()
    {
        $this->register(new Roles\Mysql());
        $this->register(new Roles\Mariadb());
        $this->register(new Roles\Pgsql());
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Phansible\Renderer\PlaybookRenderer $playbook
     */
    public function setupRole(Request $request, PlaybookRenderer $playbook)
    {
        foreach ($this->roles as $role) {
            /** @var RoleInterface $role */
            $role->setup($request, $playbook);
        }
    }
}
