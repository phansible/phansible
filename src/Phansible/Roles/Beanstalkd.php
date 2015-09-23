<?php

namespace Phansible\Roles;

use Phansible\Role;

class Beanstalkd implements Role
{
    public function getName()
    {
        return 'Beanstalkd';
    }

    public function getSlug()
    {
        return 'beanstalkd';
    }

    public function getRole()
    {
        return 'beanstalkd';
    }

    public function getInitialValues()
    {
        return [
            'install'        => 0,
            'listenAddress'  => '0.0.0.0',
            'listenPort'     => '13000',
            'version'        => '1.10',
            'user'           => 'beanstalkd',
            'persistent'     => 'yes',
            'storage'        => '/var/lib/beanstalkd',
        ];
    }
}
