<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Beanstalkd
 * @package App\Phansible\Roles
 */
class Beanstalkd implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Beanstalkd';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'beanstalkd';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'beanstalkd';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'       => 0,
            'listenAddress' => '0.0.0.0',
            'listenPort'    => '13000',
            'version'       => '1.10',
            'user'          => 'beanstalkd',
            'persistent'    => 'yes',
            'storage'       => '/var/lib/beanstalkd',
        ];
    }
}
