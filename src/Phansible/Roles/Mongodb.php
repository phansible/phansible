<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Mongodb extends BaseRole
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
