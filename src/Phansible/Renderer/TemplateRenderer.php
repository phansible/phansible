<?php
/**
 * Template File Renderer
 * Generic Renderer for templates
 */

namespace Phansible\Renderer;

use Phansible\Model\FileRendererInterface;

class TemplateRenderer implements FileRendererInterface
{
    /** @var string Path for Twig Template */
    protected $templateFile;

    /** @var array Data to render the template */
    protected $data;

    /** @var string Path to save the rendered file */
    protected $filePath;

    /**
     * Default constructor just loads defaults
     */
    public function __construct()
    {
        $this->loadDefaults();
    }

    /**
     * Renders the Template
     * @param \Twig_Environment $twig
     * @return string Rendered template contents
     */
    public function renderFile(\Twig_Environment $twig)
    {
        return $twig->render($this->getTemplate(), $this->getData());
    }

    /**
     * Loads any default values
     * @return void
     */
    public function loadDefaults()
    {
        return null;
    }

    /**
     * Sets the Template Path
     * @param string $templateFile
     */
    public function setTemplate($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate()
    {
        return $this->templateFile;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $item) {
            $this->add($key, $item);
        }
    }

    /**
     * Returns the data for the template
     * @return Array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
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
     * Defines the path where the rendered file should be saved
     * @param $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * FilePath for saving the rendered template
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
