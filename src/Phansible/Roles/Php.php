<?php

namespace App\Phansible\Roles;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Role;
use App\Phansible\RoleValuesTransformer;

class Php implements Role, RoleValuesTransformer
{
    public function getName(): string
    {
        return 'PHP';
    }

    public function getSlug(): string
    {
        return 'php';
    }

    public function getRole(): string
    {
        return 'php';
    }

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
     * @param $values
     * @return array
     */
    protected function addPhpPackage($package, $values): array
    {
        if (in_array($package, $values['packages'], true) === false) {
            $values['packages'][] = $package;
        }

        return $values;
    }
}
