<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Sqlite extends BaseRole
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
