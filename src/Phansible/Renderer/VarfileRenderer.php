<?php
/**
 * Var File renderer
 */

namespace Phansible\Renderer;

use Symfony\Component\Yaml\Yaml;

class VarfileRenderer extends TemplateRenderer
{
    /** @var  array Variables key-value format */
    protected $data = [];

    /** @var  string Varfile name */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function loadDefaults()
    {
        $this->setTemplate('vars.yml.twig');
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function addMultipleVars(array $vars)
    {
        $this->data = array_merge($this->data, $vars);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return ['variables' => Yaml::dump($this->data), 'name' => $this->name];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return 'ansible/vars/' . $this->getName() . '.yml';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
