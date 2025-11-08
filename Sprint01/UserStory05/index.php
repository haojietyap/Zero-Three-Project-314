<?php
declare(strict_types=1);

// Autoload Boundary / Controller / Entity
spl_autoload_register(function($class){
    foreach (['Boundary','Controller','Entity'] as $dir) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $class . '.php';
        if (is_file($path)) { require_once $path; return; }
    }
});

// (Optional) show PHP errors during setup (disable in prod)
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Boot
$page = new AdminUsersPage();
$page->handle();
