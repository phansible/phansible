<?php

namespace Phansible\Roles;

use Phansible\Role;

class Mongodb implements Role
{
    public function getName()
    {
        return 'MongoDb';
    }

    public function getSlug()
    {
        return 'mongodb';
    }

    public function getRole()
    {
        return 'mongodb';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
        ];
    }
}
