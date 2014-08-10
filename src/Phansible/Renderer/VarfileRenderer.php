<?php
/**
 * Var File renderer
 */

namespace Phansible\Renderer;

use Phansible\Model\AbstractFileRenderer;

class VarfileRenderer extends AbstractFileRenderer
{
    protected $data;
    protected $filename;

    public function  __construct($filename)
    {
        $this->filename = $filename;
        parent::__construct();
    }

    public function loadDefaults()
    {
        return null;
    }

    public function add($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->data[$key] = $value;
    }

    public function getTemplate()
    {
        return 'vars.yml.twig';
    }

    /**
     * Returns the data for the template
     * @return Array
     */
    public function getData()
    {
        return [ 'variables' => $this->data ];
    }

    /**
     * FilePath for saving the rendered template
     */
    public function getFilePath()
    {
        return 'ansible/vars/' . $this->filename . '.yml';
    }


} 