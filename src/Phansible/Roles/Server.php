<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

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
