<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/helpers.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Load the DotEnv to read environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Load Eloquent to work with database
$capsule = new Capsule;
$capsule->addConnection([
    "driver" => env('DB_CONNECTION'),
    "host" => env('DB_HOST'),
    "database" => env('DB_DATABASE'),
    "username" => env('DB_USERNAME'),
    "password" => env('DB_PASSWORD')
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();