<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;

class Php implements RoleInterface, RoleValuesTransformer
{
    public function getName()
    {
        return 'PHP';
    }

    public function getSlug()
    {
        return 'php';
    }

    public function getRole()
    {
        return 'php';
    }

    public function requiresRoles()
    {
        return [];
    }

    public function getInitialValues()
    {
        return [
          'install' => 1,
          'packages' => [
            'php5-cli',
            'php5-intl',
            'php5-mcrypt',
          ],
          'peclpackages' => []
        ];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {
        $map = [
            "mysql"   => "php5-mysql",
            "mariadb" => "php5-mysql",
            "pgsql"   => "php5-pgsql",
            "sqlite"  => "php5-sqlite",
            "mongodb" => "php5-mongo",
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
     * @param array $requestVars
     */
    protected function addPhpPackage($package, $values)
    {
        if (in_array($package, $values['packages']) === false) {
            $values['packages'][] = $package;
        }

        return $values;
    }
}
