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
            'maxJobSize'     => '65535',
            'maxConnections' => '1024',
            'binLog'         => '/var/lib/beanstalkd/binlog',
        ];
    }
}
