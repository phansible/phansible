<?php
/**
 * FileRenderer Interface
 */

namespace Phansible\Model;

interface FileRendererInterface
{
    /**
     * Renders the template with current data
     *
     * @param \Twig_Environment $twig
     * @return string Rendered template
     */
    public function renderFile(\Twig_Environment $twig);

    /**
     * Loads any default values
     * @return void
     */
    public function loadDefaults();

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate();

    /**
     * Returns the data for the template
     * @return array
     */
    public function getData();

    /**
     * FilePath for saving the rendered template
     * @return string
     */
    public function getFilePath();
}
