<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Beanstalkd extends BaseRole
{
    protected $name = 'Beanstalkd';
    protected $slug = 'beanstalkd';
    protected $role = 'beanstalkd';

    public function getInitialValues()
    {
        return [
            'listenAddress'  => '0.0.0.0',
            'listenPort'     => '13000',
            'version'        => '1.10',
            'user'           => 'beanstalkd',
            'persistent'     => 'yes',
            'storage'        => '/var/lib/beanstalkd',
        ];
    }
}
