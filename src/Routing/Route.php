<?php

namespace App\Routing;

use Laminas\Diactoros\ResponseFactory;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use League\Route\Strategy\StrategyInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use App\Routing\ServerRequestFactory;

class Route
{
    private Router $router;

    public function __construct(
        private Container $app,
        private array $strategies = []
    ) {
        $this->router = new Router();
    }

    public function handle(): void
    {
        $this->initialize();

        $response = $this->router->dispatch(
            $this->app->get(ServerRequestFactory::class)
        );

        $this->app->get(SapiEmitter::class)->emit($response);
    }

    public function initialize(): void
    {
        $this->strategies[] = $this->getDefaultStrategy();

        $this->registerStrategy();

        $this->app->addShared('router', $this);
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function loadRoutes(string $routes)
    {
        $router = $this->router;

        require $routes;
    }

    protected function registerStrategy(): void
    {
        foreach ($this->strategies as $strategy) {
            $this->router->setStrategy($strategy);
        }
    }

    protected function getDefaultStrategy(): StrategyInterface
    {
        return new JsonStrategy(
            new ResponseFactory()
        );
    }
}
