<?php

declare(strict_types=1);

use App\Kernel;
use App\Routing\Route;

require 'vendor/autoload.php';

$app = (new Kernel(__DIR__))
    ->make();

$router = new Route($app->getContainer());

$router->handle();
