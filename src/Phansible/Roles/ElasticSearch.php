<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class ElasticSearch
 * @package App\Phansible\Roles
 */
class ElasticSearch implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ElasticSearch';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'elasticsearch';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'elasticsearch';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'version' => '1.5.2',
            'port'    => '9200',
        ];
    }
}
