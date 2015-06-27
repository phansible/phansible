<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Nginx implements RoleInterface
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
          'install' => 1,
          'docroot' => '/vagrant',
          'servername' => 'myApp.vb'
        ];
    }
}
