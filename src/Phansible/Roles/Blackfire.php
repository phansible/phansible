<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Blackfire
 * @package App\Phansible\Roles
 */
class Blackfire implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Blackfire';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'blackfire';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'blackfire';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'      => 0,
            'server_id'    => '',
            'server_token' => '',
        ];
    }
}
