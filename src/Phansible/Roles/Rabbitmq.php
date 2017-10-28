<?php

namespace Phansible\Roles;

use Phansible\Role;

class Rabbitmq implements Role
{
    public function getName()
    {
        return 'RabbitMQ';
    }

    public function getSlug()
    {
        return 'rabbitmq';
    }

    public function getRole()
    {
        return 'rabbitmq';
    }

    public function getInitialValues()
    {
        return [
            'install'  => 0,
            'plugins'  => [],
            'hostname' => 'phansible',
            'user'     => 'user',
            'password' => 'password'
        ];
    }
}
