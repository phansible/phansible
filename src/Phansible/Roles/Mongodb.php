<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Mongodb extends BaseRole
{
    protected $name = 'MongoDB';
    protected $slug = 'mongodb';
    protected $role = 'mongodb';


    public function getInitialValues()
    {
        return [
          'install' => 0,
          'port' => 27017,
        ];
    }
}
