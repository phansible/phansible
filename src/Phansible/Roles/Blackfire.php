<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class Blackfire implements Role
{
    public function getName(): string
    {
        return 'Blackfire';
    }

    public function getSlug(): string
    {
        return 'blackfire';
    }

    public function getRole(): string
    {
        return 'blackfire';
    }

    public function getInitialValues(): array
    {
        return [
            'install'      => 0,
            'server_id'    => '',
            'server_token' => '',
        ];
    }
}
