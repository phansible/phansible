<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Nginx
 * @package App\Phansible\Roles
 */
class Nginx implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Nginx';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'nginx';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'nginx';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'    => 1,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
