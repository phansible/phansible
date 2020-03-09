<?php
/**
 * FileRenderer Interface
 */

namespace App\Phansible\Model;

use Twig\Environment;

/**
 * Interface FileRendererInterface
 * @package App\Phansible\Model
 */
interface FileRendererInterface
{
    /**
     * Renders the template with current data
     *
     * @param Environment $twig
     * @return string Rendered template
     */
    public function renderFile(Environment $twig): string;

    /**
     * Loads any default values
     * @return void
     */
    public function loadDefaults(): void;

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Returns the data for the template
     * @return array
     */
    public function getData(): array;

    /**
     * FilePath for saving the rendered template
     * @return string
     */
    public function getFilePath(): string;
}
