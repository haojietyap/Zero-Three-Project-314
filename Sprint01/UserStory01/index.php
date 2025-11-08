<?php
declare(strict_types=1);
spl_autoload_register(function ($class) {
    foreach (['Boundary','Controller','Entity'] as $dir) {
        $path = __DIR__ . "/$dir/$class.php";
        if (is_file($path)) { require_once $path; return; }
    }
});
$page = new AdminCreateUserPage();
$page->handle();
