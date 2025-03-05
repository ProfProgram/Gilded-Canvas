<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
// FOR LOCAL
require __DIR__.'/../vendor/autoload.php';
// FOR REMOTE SERVER
//require __DIR__.'/../TheGuildedCanvas/vendor/autoload.php';


// Bootstrap Laravel and handle the request...
// FOR LOCAL
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
// FOR REMOTE SERVER
//(require_once __DIR__.'/../TheGuildedCanvas/bootstrap/app.php')
//    ->handleRequest(Request::capture());
