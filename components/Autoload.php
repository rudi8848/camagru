<?php

$paths = [
    '/models/',
    '/components/',
    '/controllers/'
];

spl_autoload_register(function($className) use ($paths) {
    foreach ($paths as $path) {

        $path = ROOT.$path.$className.'.php';

        if (is_file($path)) {
            require_once ($path);
        }
    }
});
