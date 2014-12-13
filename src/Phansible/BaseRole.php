<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\Yaml\Yaml;

abstract class BaseRole implements RoleInterface
{

    protected $name;
    protected $slug;
    protected $role;

    protected $customData = [];

    /**
     * @var \Phansible\Application
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if (!$this->name) {
            throw new \Exception('Role name has not been defined');
        }
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        if (!$this->slug) {
            throw new \Exception('Role slug has not been defined');
        }
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        if (!$this->role) {
            throw new \Exception('Role roles name has not been defined');
        }
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setup(VagrantBundle $vagrantBundle)
    {
        $config = $this->getData();
        if (!$this->installRole($config)) {
            return;
        }

        if (!is_null($this->role)) {
            $vagrantBundle->getPlaybook()->addRole($this->role);
        }

        $vagrantBundle->getVarsFile()->addMultipleVars([$this->getSlug() => $config]);
    }

    protected function installRole($config)
    {
        /*
         * If the configuration doesn't have a section for this role
         * or if it'say not to install return false.
         */
        if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] === 0) {
            return false;
        }
        return true;
    }

    /**
     * Return data needed for the templates
     *
     * @param bool $returnAvailableData
     * @return array
     */
    public function getData($returnAvailableData = false)
    {
        // User-specified, or the default filled-on data
        $dataToMerge = empty($this->customData)
          ? $this->getInitialValues()
          : $this->customData;

        if (is_null($dataToMerge)) {
            $dataToMerge = [];
        }

        // All available options. Don't want these in generated user-facing yaml file
        if ($returnAvailableData) {
            $dataToMerge = array_merge(
              $this->getAvailableOptions(),
              $dataToMerge
            );
        }

        // Sane defaults for all data options
        $data = array_replace_recursive(
          $this->getBaseData(),
          $dataToMerge
        );

        return $data;
    }

    /**
     * Add user-supplied values
     *
     * @param array $data
     * @return $this
     */
    public function setCustomData(array $data = [])
    {
        $this->customData = $data;

        return $this;
    }

    /**
     * Base data
     * @return array
     */
    protected function getBaseData()
    {
        return $this->yamlParse('data.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getInitialValues()
    {
        return $this->yamlParse('initial.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableOptions()
    {
        return $this->yamlParse('available.yml');
    }

    /**
     * Parse a YAML file from dataLocation root
     *
     * @param string $file
     * @return array
     */
    protected function yamlParse($file)
    {
        $data = Yaml::parse(__DIR__ . '/Resources/config/roles/' . $this->getRole() . '/' . $file);
        if (!is_array($data)) {
            return [];
        }
        return $data;
    }
}
