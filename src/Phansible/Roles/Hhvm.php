<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Hhvm
 * @package App\Phansible\Roles
 */
class Hhvm implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'HHVM';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'hhvm';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'hhvm';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'host'    => '127.0.0.1',
            'port'    => 9000,
        ];
    }
}
