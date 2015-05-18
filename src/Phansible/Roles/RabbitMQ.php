<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class RabbitMQ extends BaseRole
{
    protected $name = 'RabbitMQ';
    protected $slug = 'rabbitmq';
    protected $role = 'rabbitmq';

    public function getInitialValues()
    {
        return [
            'install'  => 0,
            'plugins'  => [],
            'user'     => 'user',
            'password' => 'password'
        ];
    }
}
