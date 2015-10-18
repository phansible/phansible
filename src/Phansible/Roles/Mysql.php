<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;

class Mysql implements Role, RoleValuesTransformer
{
    public function getName()
    {
        return 'MySQL';
    }

    public function getSlug()
    {
        return 'mysql';
    }

    public function getRole()
    {
        return 'mysql';
    }

    public function getInitialValues()
    {
        return [
            'install' => 1,
            'root_password' => 123,
            'dump'          => '',
            'users'         => [
                [
                    'user'      => 'user',
                    'password'  => 'password'
                ]
            ]
        ];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {
        $values['users'] = array_values($values['users']);

        return $values;
    }
}
