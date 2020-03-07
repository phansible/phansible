<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

class Beanstalkd implements Role
{
    public function getName(): string
    {
        return 'Beanstalkd';
    }

    public function getSlug(): string
    {
        return 'beanstalkd';
    }

    public function getRole(): string
    {
        return 'beanstalkd';
    }

    public function getInitialValues(): array
    {
        return [
            'install'       => 0,
            'listenAddress' => '0.0.0.0',
            'listenPort'    => '13000',
            'version'       => '1.10',
            'user'          => 'beanstalkd',
            'persistent'    => 'yes',
            'storage'       => '/var/lib/beanstalkd',
        ];
    }
}
