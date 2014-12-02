<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Composer extends BaseRole
{
    protected $name = 'Composer';
    protected $slug = 'composer';
    protected $role = 'composer';

    public function getInitialValues()
    {
        return [
          'install' => 0,
        ];
    }
}
