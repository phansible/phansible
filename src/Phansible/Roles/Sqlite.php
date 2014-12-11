<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Sqlite extends BaseRole
{
    protected $name = 'SQLite';
    protected $slug = 'sqlite';
    protected $role = 'sqlite';


    public function getInitialValues()
    {
        return [
          'install' => 0,
        ];
    }
}
