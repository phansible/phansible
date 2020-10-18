<?php
/**
 * Var File renderer
 */

namespace App\Phansible\Renderer;

use Symfony\Component\Yaml\Yaml;

/**
 * Class VarfileRenderer
 * @package App\Phansible\Renderer
 */
class VarfileRenderer extends TemplateRenderer
{
    /**
     * @var array Variables key-value format
     */
    protected $data = [];

    /**
     * @var string Varfile name
     */
    protected $name;

    /**
     * VarfileRenderer constructor.
     * @param string $name
     */
    public function __construct(string $name)
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

    /**
     * @param array $vars
     */
    public function addMultipleVars(array $vars): void
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
