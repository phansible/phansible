<?php
/**
 * Abstract File Renderer
 */

namespace Phansible\Model;

abstract class AbstractFileRenderer implements FileRenderer
{
    public function __construct()
    {
        $this->loadDefaults();
    }

    public function renderFile(\Twig_Environment $twig)
    {
        return $twig->render($this->getTemplate(), $this->getData());
    }
} 