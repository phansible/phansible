<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Mysql extends BaseRole
{
  protected $name = 'MySQL';
  protected $slug = 'mysql';
  protected $role = 'mysql';

  public function getInitialValues()
  {
    return [
      'install' => 1,
      'root_password' => 123
    ];
  }


  public function setup(Request $request, PlaybookRenderer $playbook)
  {
    $config = $request->get($this->slug);
    if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] === 0) {
      return;
    }
    $playbook->addRole($this->role);

    $dbVars = new VarfileRenderer($this->slug);
    $dbVars->add('root_password', $config['root-password'], false);
    $dbVars->add('user', $config['user'], false);
    $dbVars->add('password', $config['password'], false);
    $dbVars->add('database', $config['database'], false);

    $dbVars->setTemplate('roles/db.vars.twig');
    $playbook->addVarsFile($dbVars);
  }
}
