<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Rabbitmq
 * @package App\Phansible\Roles
 */
class Rabbitmq implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'RabbitMQ';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'rabbitmq';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'rabbitmq';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'  => 0,
            'plugins'  => [],
            'user'     => 'user',
            'password' => 'password',
        ];
    }
}
