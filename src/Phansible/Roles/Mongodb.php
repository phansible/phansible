<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Mongodb extends BaseRole
{
    protected $name = 'MongoDB';
    protected $slug = 'mongodb';
    protected $role = 'mongodb';


    public function getInitialValues()
    {
        return [
          'install' => 0,
        ];
    }
}
