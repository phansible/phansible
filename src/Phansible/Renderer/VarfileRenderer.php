<?php
/**
 * Var File renderer
 */

namespace Phansible\Renderer;

use Phansible\Model\AbstractFileRenderer;

class VarfileRenderer extends AbstractFileRenderer
{
    /** @var  array Variables key-value format */
    protected $data;

    /** @var  string Varfile name */
    protected $name;

    /** @var  string Template */
    protected $template;

    /**
     * @param string $name
     */
    public function  __construct($name)
    {
        $this->name = $name;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function loadDefaults()
    {
        $this->template = 'vars.yml.twig';
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [ 'variables' => $this->data ];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return 'ansible/vars/' . $this->name . '.yml';
    }

} 