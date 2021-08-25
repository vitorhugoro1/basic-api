<?php

namespace App;

use League\Container\Container;
use League\Container\ServiceProvider\ServiceProviderInterface;
use League\Container\ReflectionContainer;
use App\Providers\RouteServiceProvider;

class Kernel
{
    private Container $app;

    /** @var array<ServiceProviderInterface> */
    private array $providers = [
        RouteServiceProvider::class
    ];

    public function __construct(private string $basepath)
    {
        $this->app = new Container();
    }

    public function make(): self
    {
        $this->app->delegate(new ReflectionContainer());

        $this->setUpBasePath();

        $this->registerProviders();

        return $this;
    }

    public function getContainer(): Container
    {
        return $this->app;
    }

    public function addProvider(string $class): self
    {
        $this->providers[] = $class;

        return $this;
    }

    protected function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->addServiceProvider(new $provider());
        }
    }

    protected function setUpBasePath()
    {
        $this->app->addShared('base_path', $this->basepath);
    }
}
