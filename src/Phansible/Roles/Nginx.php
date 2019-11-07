<?php

namespace Phansible\Roles;

use Phansible\Role;

class Nginx implements Role
{
    public function getName()
    {
        return 'Nginx';
    }

    public function getSlug()
    {
        return 'nginx';
    }

    public function getRole()
    {
        return 'nginx';
    }

    public function getInitialValues()
    {
        return [
            'install'    => 1,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
