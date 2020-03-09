<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Mongodb
 * @package App\Phansible\Roles
 */
class Mongodb implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'MongoDb';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'mongodb';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'mongodb';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
        ];
    }
}
