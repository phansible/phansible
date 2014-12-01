<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Hhvm extends BaseRole
{
    protected $name = 'HHVM';
    protected $slug = 'hhvm';
    protected $role = 'hhvm';


    public function getInitialValues()
    {
        return [
          'install' => 0,
          'host' => '127.0.0.1',
          'port' => 9000,
        ];
    }

    public function setup(array $requestVars, PlaybookRenderer $playbook, VarfileRenderer $varFile)
    {
        parent::setup($requestVars, $playbook, $varFile);

        if ($requestVars[$this->slug()]['composer'] == 1) {
            $playbook->addRole('composer');
        }
    }
}
