<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Mysql extends BaseRole
{
  public function setup(Request $request, PlaybookRenderer $playbook)
  {
    throw new \Exception("Ttest error");
    $config = $request->get('mysql');
    if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] === 0) {
      // No Mysql wanted
      return;
    }
    $playbook->addRole('mysql');

    $dbVars = new VarfileRenderer('mysql');
    $dbVars->add('root_password', $config['root-password'], false);
    $dbVars->add('user', $config['user'], false);
    $dbVars->add('password', $config['password'], false);
    $dbVars->add('database', $config['database'], false);

    $dbVars->setTemplate('roles/db.vars.twig');
    $playbook->addVarsFile($dbVars);
  }
}
