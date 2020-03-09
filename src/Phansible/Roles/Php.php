<?php

namespace App\Phansible\Roles;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Role;
use App\Phansible\RoleValuesTransformer;

/**
 * Class Php
 * @package App\Phansible\Roles
 */
class Php implements Role, RoleValuesTransformer
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'PHP';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'php';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'php';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'      => 1,
            'packages'     => [
                'php5-cli',
                'php5-intl',
                'php5-mcrypt',
            ],
            'peclpackages' => [],
        ];
    }

    /**
     * @param array $values
     * @param VagrantBundle $vagrantBundle
     * @return array
     */
    public function transformValues(array $values, VagrantBundle $vagrantBundle): array
    {
        $map = [
            'mysql'   => 'php5-mysql',
            'mariadb' => 'mysql',
            'pgsql'   => 'pgsql',
            'sqlite'  => 'sqlite',
            'mongodb' => 'mongo',
        ];

        $playbook = $vagrantBundle->getPlaybook();

        foreach ($map as $role => $package) {
            if ($playbook->hasRole($role)) {
                $values = $this->addPhpPackage($package, $values);
            }
        }

        return $values;
    }

    /**
     * @param string $package
     * @param array $values
     * @return array
     */
    protected function addPhpPackage(string $package, array $values): array
    {
        if (in_array($package, $values['packages'], true) === false) {
            $values['packages'][] = $package;
        }

        return $values;
    }
}
