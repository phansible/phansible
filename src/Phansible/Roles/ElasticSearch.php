<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class ElasticSearch implements Role
{
    public function getName(): string
    {
        return 'ElasticSearch';
    }

    public function getSlug(): string
    {
        return 'elasticsearch';
    }

    public function getRole(): string
    {
        return 'elasticsearch';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'version' => '1.5.2',
            'port'    => '9200',
        ];
    }
}
