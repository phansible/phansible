<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Zookeeper
 * @package App\Phansible\Roles
 */
class Zookeeper implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Zookeeper';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'zookeeper';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'zookeeper';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 1,
            'version' => '3.4.6',
            'port'    => '2181',
        ];
    }
}
