<?php

namespace Phansible\Roles;

use Phansible\Role;

class Apache implements Role
{
    public function getName(): string
    {
        return 'Apache';
    }

    public function getSlug(): string
    {
        return 'apache';
    }

    public function getRole(): string
    {
        return 'apache';
    }

    public function getInitialValues(): array
    {
        return [
            'install'    => 0,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
