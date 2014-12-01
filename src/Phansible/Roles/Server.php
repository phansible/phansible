<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Server extends BaseRole
{
    protected $name = 'Server';
    protected $slug = 'server';
    protected $role = 'server';

    public function getInitialValues()
    {
        return [
          'install' => 1,
          'timezone' => 'UTC',
        ];
    }
}
