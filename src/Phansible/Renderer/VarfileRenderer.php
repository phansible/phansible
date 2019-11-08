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
    public function loadDefaults(): void
    {
        $this->setTemplate('vars.yml.twig');
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value): void
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
    public function getData(): array
    {
        return ['variables' => Yaml::dump($this->data), 'name' => $this->name];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilePath(): string
    {
        return 'ansible/vars/' . $this->getName() . '.yml';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}
