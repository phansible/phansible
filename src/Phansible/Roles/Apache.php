<?php

namespace Phansible\Roles;

use Phansible\Role;

class Apache implements Role
{
    public function getName()
    {
        return 'Apache';
    }

    public function getSlug()
    {
        return 'apache';
    }

    public function getRole()
    {
        return 'apache';
    }

    public function getInitialValues()
    {
        return [
            'install'    => 0,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
