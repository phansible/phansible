<?php

namespace Phansible\Roles;

use Phansible\Role;

class Sqlite implements Role
{
    public function getName(): string
    {
        return 'SQLite';
    }

    public function getSlug(): string
    {
        return 'sqlite';
    }

    public function getRole(): string
    {
        return 'sqlite';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
        ];
    }
}
