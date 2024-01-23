<?php

define('URL_PREFIX', '');

define('DATABASE_HOST', 'mysql');
define('DATABASE_USER', 'php_template');
define('DATABASE_PASS', 'root');
define('DATABASE_NAME', 'php_template');

// Autoload classes
spl_autoload_register(function ($file) {
    $folders = ['modules'];

    foreach ($folders as $folder) {
        if (file_exists(__DIR__ . '/' . $folder . '/' . $file . '.php')) {
            require_once __DIR__ . '/' . $folder . '/' . $file . '.php';
            return;
        }
    }

    if (file_exists(__DIR__ . '/' . $file . '.php')) {
        require_once __DIR__ . '/' . $file . '.php';
    }
});

// Start session
session_start();

// Get the user from the session
Auth::loadUser();
