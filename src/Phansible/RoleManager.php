<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Roles\Mysql;
use Symfony\Component\HttpFoundation\Request;

class RoleManager {

  protected $roles = [];

  public function __construct()
  {
    $this->registerRoles();
  }

  protected function registerRoles()
  {
    $this->register(new Mysql());

  }

  public function register(RoleInterface $role)
  {
    $this->roles[] = $role;
  }

  public function getRoles()
  {
    return $this->roles;
  }

  public function setupRole(Request $request, PlaybookRenderer $playbook)
  {
    foreach ($this->roles as $role) {
      /** @var RoleInterface $role */
      $role->setup($request, $playbook);
    }
  }
}
