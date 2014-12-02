<?php

namespace Phansible\Roles;

class Mariadb extends Mysql
{
  protected $name = 'MariaDb';
  protected $slug = 'mariadb';
  protected $role = 'mariadb';

  public function getInitialValues()
  {
    return [
      'install' => 0,
      'root_password' => 123,
      'databases' => [
        'name' => 'dbname',
        'user' => 'name',
        'password' => 123,
      ]
    ];
  }
}
