<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Symfony\Component\HttpFoundation\Request;

interface RoleInterface
{
    public function __construct(Application $app);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return array
     */
    public function getInitialValues();

    public function setup(Request $request, PlaybookRenderer $playbook);

}
