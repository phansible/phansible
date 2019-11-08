<?php

namespace Phansible\Roles;

use Phansible\Role;

class Nginx implements Role
{
    public function getName(): string
    {
        return 'Nginx';
    }

    public function getSlug(): string
    {
        return 'nginx';
    }

    public function getRole(): string
    {
        return 'nginx';
    }

    public function getInitialValues(): array
    {
        return [
            'install'    => 1,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
