<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Redis extends BaseRole
{
    protected $name = 'Redis';
    protected $slug = 'redis';
    protected $role = 'redis';


    public function getInitialValues()
    {
        return [
            'install' => 0,
            'port'    => 6379,
        ];
    }
}
