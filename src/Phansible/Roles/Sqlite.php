<?php

namespace Phansible\Roles;

use Phansible\Role;

class Sqlite implements Role
{
    public function getName()
    {
        return 'SQLite';
    }

    public function getSlug()
    {
        return 'sqlite';
    }

    public function getRole()
    {
        return 'sqlite';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
        ];
    }
}
