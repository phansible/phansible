<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Solr
 * @package App\Phansible\Roles
 */
class Solr implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Solr';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'solr';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'solr';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'version' => '5.2.0',
            'port'    => '8983',
        ];
    }
}
