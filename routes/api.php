<?php

use App\Controller\HelloWorldController;

/** @var \League\Route\Router $router */

$router->get('/', HelloWorldController::class);
