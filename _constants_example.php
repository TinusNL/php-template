<?php

define('BASE_PATH', '/php-template/');

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DATABASE_NAME', 'php-template');

define('DISCORD_REDIRECT', 'http://' . getenv('HTTP_HOST') . BASE_PATH . 'discord/process/');
define('DISCORD_CLIENT_ID', 0);
define('DISCORD_CLIENT_SECRET', '');
define('DISCORD_CLIENT_SCOPES', 'identify');

// Autoload classes
spl_autoload_register(function ($class) {
    require_once 'php/' . $class . '.php';
});
