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

        $map = $this->getPackagesMap($values['ppa']);
        $playbook = $vagrantBundle->getPlaybook();

        foreach ($map as $role => $package) {
            if ($playbook->hasRole($role)) {
                $values = $this->addPhpPackage($package, $values);
            }
        }

        return $values;
    }

    private function getPackagesMap($ppa)
    {
        $map_php5 = [
            'mysql'   => 'php5-mysql',
            'mariadb' => 'php5-mysql',
            'pgsql'   => 'php5-pgsql',
            'sqlite'  => 'php5-sqlite',
            'mongodb' => 'php5-mongo',
        ];
        $map_php7 = [
            'mysql'   => 'php7.0-mysql',
            'mariadb' => 'php7.0-mysql',
            'pgsql'   => 'php7.0-pgsql',
            'sqlite'  => 'php7.0-sqlite3',
            'mongodb' => 'php7.0-mongo',
        ];

        return  (false !== strpos($ppa, 'php-7')) ? $map_php7 : $map_php5;
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
