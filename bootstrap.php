<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', realpath(__DIR__) . DS);

if (! file_exists($autoload = ROOT . 'vendor/autoload.php')) {
    throw new RuntimeException('Dependencies not installed.');
}

require $autoload;

unset($autoload);
