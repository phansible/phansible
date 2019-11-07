<?php
/**
 * Template File Renderer
 * Generic Renderer for templates
 */

namespace Phansible\Renderer;

use Phansible\Model\FileRendererInterface;
use Twig_Environment;

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
     * Loads any default values
     * @return void
     */
    public function loadDefaults()
    {
        return null;
    }

    /**
     * Renders the Template
     * @param Twig_Environment $twig
     * @return string Rendered template contents
     */
    public function renderFile(Twig_Environment $twig)
    {
        return $twig->render($this->getTemplate(), $this->getData());
    }

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate()
    {
        return $this->templateFile;
    }

    /**
     * Returns the data for the template
     * @return Array
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $item) {
            $this->add($key, $item);
        }
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
     * Sets the Template Path
     * @param string $templateFile
     */
    public function setTemplate($templateFile)
    {
        $this->templateFile = $templateFile;
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
     * FilePath for saving the rendered template
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Defines the path where the rendered file should be saved
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }
}
