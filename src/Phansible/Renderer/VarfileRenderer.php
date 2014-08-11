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
    protected $filename;

    /** @var  string Template */
    protected $template;

    /**
     * @param $filename
     */
    public function  __construct($filename)
    {
        $this->filename = $filename;
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
     * @param $key
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
     * @param mixed $template
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
     * @param mixed $data
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
        return 'ansible/vars/' . $this->filename . '.yml';
    }

} 