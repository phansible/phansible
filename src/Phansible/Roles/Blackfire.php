<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Blackfire extends BaseRole
{
    protected $name = 'BlackFire';
    protected $slug = 'blackfire';
    protected $role = 'blackfire';

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'server_id' => '',
          'server_token' => '',
        ];
    }
}
