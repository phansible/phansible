<?php

if (! file_exists($autoload = '../vendor/autoload.php')) {
    throw new RuntimeException('Dependencies not installed.');
}

require $autoload;

unset($autoload);

