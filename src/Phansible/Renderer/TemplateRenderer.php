<?php
/**
 * Template File Renderer
 * Generic Renderer for templates
 */

namespace App\Phansible\Renderer;

use App\Phansible\Model\FileRendererInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TemplateRenderer
 * @package App\Phansible\Renderer
 */
class TemplateRenderer implements FileRendererInterface
{
    /**
     * @var string Path for Twig Template
     */
    protected $templateFile;

    /**
     * @var array Data to render the template
     */
    protected $data;

    /**
     * @var string Path to save the rendered file
     */
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
    public function loadDefaults(): void
    {
    }

    /**
     * Renders the Template
     * @param Environment $twig
     * @return string Rendered template contents
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function renderFile(Environment $twig): string
    {
        return $twig->render($this->getTemplate(), $this->getData());
    }

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->templateFile;
    }

    /**
     * Returns the data for the template
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        foreach ($data as $key => $item) {
            $this->add($key, $item);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Sets the Template Path
     * @param string $templateFile
     */
    public function setTemplate(string $templateFile): void
    {
        $this->templateFile = $templateFile;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * FilePath for saving the rendered template
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Defines the path where the rendered file should be saved
     * @param string $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }
}
