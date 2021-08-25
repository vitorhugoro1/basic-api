<?php

namespace Tests;

use App\Kernel;
use App\Routing\Route;
use League\Container\Container;
use PHPUnit\Framework\TestCase as BaseTestCase;
use App\Routing\ServerRequestFactory;

class TestCase extends BaseTestCase
{
    protected Container $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }

    protected function createApplication(): void
    {
        $kernel = (new Kernel(__DIR__ . '/..'))->make();

        $this->app = $kernel->getContainer();
    }

    protected function call(string $method, string $uri): \Psr\Http\Message\ResponseInterface
    {
        $router = new Route($this->app);

        $router->initialize();

        $this->app
            ->get('router')
            ->loadRoutes(
                $this->app->get('base_path') . '/routes/api.php'
            );

        $request = (new ServerRequestFactory())->createServerRequest($method, $uri);

        $response = $router->getRouter()->dispatch(
            $request
        );

        return $response;
    }
}
