<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Pgsql extends BaseRole
{
  public function setup(Request $request, PlaybookRenderer $playbook)
  {
    $config = $request->get('pgsql');
    if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] === 0) {
      // No Postgresql wanted
      return;
    }
    $playbook->addRole('pgsql');

    $dbVars = new VarfileRenderer('pgsql');
    $dbVars->add('user', $config['user'], false);
    $dbVars->add('password', $config['password'], false);
    $dbVars->add('database', $config['database'], false);

    $dbVars->setTemplate('roles/db.vars.twig');
    $playbook->addVarsFile($dbVars);
  }
}
