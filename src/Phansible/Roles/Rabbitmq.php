<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class Rabbitmq implements Role
{
    public function getName(): string
    {
        return 'RabbitMQ';
    }

    public function getSlug(): string
    {
        return 'rabbitmq';
    }

    public function getRole(): string
    {
        return 'rabbitmq';
    }

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
