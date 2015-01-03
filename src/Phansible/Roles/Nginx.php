<?php

namespace Phansible\Roles;

class Nginx extends Apache
{
    protected $name = 'Nginx';
    protected $slug = 'nginx';
    protected $role = 'nginx';

    public function getInitialValues()
    {
        return [
          'install' => 1,
          'docroot' => '/vagrant',
          'servername' => 'myApp.vb'
        ];
    }
}
