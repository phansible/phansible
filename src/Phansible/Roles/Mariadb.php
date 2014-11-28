<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Mariadb extends Mysql
{
  protected $name = 'MariaDb';
  protected $slug = 'mariadb';
  protected $role = 'mariadb';

  public function getInitialValues()
  {
    return [
      'install' => 1,
      'root_password' => 123
    ];
  }
}
