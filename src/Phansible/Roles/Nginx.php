<?php

namespace Phansible\Roles;

class Nginx extends Apache
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
