<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;

class Mariadb implements Role, RoleValuesTransformer
{
    public function getName()
    {
        return 'MariaDb';
    }

    public function getSlug()
    {
        return 'mariadb';
    }

    public function getRole()
    {
        return 'mariadb';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
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
