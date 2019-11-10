<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class Mongodb implements Role
{
    public function getName(): string
    {
        return 'MongoDb';
    }

    public function getSlug(): string
    {
        return 'mongodb';
    }

    public function getRole(): string
    {
        return 'mongodb';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
        ];
    }
}
