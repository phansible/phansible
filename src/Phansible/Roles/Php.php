<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Php extends BaseRole
{
    protected $name = 'PHP';
    protected $slug = 'php';
    protected $role = 'php';


    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        if (!$this->installRole($requestVars)) {
            return;
        }

        if ($this->installRole($requestVars, 'mysql') || $this->installRole($requestVars, 'mariadb')) {
            $this->addPhpPackage('php5-mysql', $requestVars);
        }

        if ($this->installRole($requestVars, 'pgsql')) {
            $this->addPhpPackage('php5-pgsql', $requestVars);
        }

        parent::setup($requestVars, $vagrantBundle);
    }

    /**
     * @param string $package
     * @param array $requestVars
     * @throws \Exception
     */
    protected function addPhpPackage($package, &$requestVars)
    {
        if (in_array($package, $requestVars[$this->getSlug()]['packages']) === false) {
            $requestVars[$this->getSlug()]['packages'][] = $package;
        }
    }
}
