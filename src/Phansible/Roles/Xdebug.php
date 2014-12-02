<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Xdebug extends BaseRole
{
    protected $name = 'XDebug';
    protected $slug = 'xdebug';
    protected $role = 'xdebug';

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'settings' => [],
        ];
    }
}
