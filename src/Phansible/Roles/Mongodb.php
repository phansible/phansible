<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Mongodb implements RoleInterface
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
