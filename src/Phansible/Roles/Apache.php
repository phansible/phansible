<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Apache
 * @package App\Phansible\Roles
 */
class Apache implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Apache';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'apache';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'apache';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'    => 0,
            'docroot'    => '/vagrant',
            'servername' => 'myApp.vb',
        ];
    }
}
