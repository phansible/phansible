<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class Solr implements Role
{
    public function getName(): string
    {
        return 'Solr';
    }

    public function getSlug(): string
    {
        return 'solr';
    }

    public function getRole(): string
    {
        return 'solr';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'version' => '5.2.0',
            'port'    => '8983',
        ];
    }
}
