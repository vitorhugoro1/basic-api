<?php

namespace App\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Routing\ServerRequestFactory;
use Laminas\Diactoros\ResponseFactory;

class RouteServiceProvider extends AbstractServiceProvider
{
    private array $services = [
        ServerRequestFactory::class
    ];

    public function provides(string $id): bool
    {
        return in_array($id, $this->services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(ServerRequestFactory::class, fn () => ServerRequestFactory::fromGlobals());

        $this->getContainer()
            ->get('router')
            ->loadRoutes(
                $this->getContainer()->get('base_path') . '/routes/api.php'
            );
    }

    public function boot(): void
    {
    }
}
