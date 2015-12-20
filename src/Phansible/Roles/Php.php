<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;

class Php implements Role, RoleValuesTransformer
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
        $prefix = strpos($values['ppa'], 'php-5')!==false ? 'php5' : 'php7.0';
        $map = [
            "mysql"   => $prefix . "-mysql",
            "mariadb" => $prefix . "-mysql",
            "pgsql"   => $prefix . "-pgsql",
            "sqlite"  => $prefix . "-sqlite",
            "mongodb" => $prefix . "-mongo",
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
