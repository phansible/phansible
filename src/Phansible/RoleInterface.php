<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Symfony\Component\HttpFoundation\Request;

interface RoleInterface
{
    public function __construct();

    public function setup(Request $request, PlaybookRenderer $playbook);

}
