<?php

namespace Artisan\Aviator;

use Illuminate\Support\Collection;

class Aviator
{
    protected $resources = [];

    protected $metrics = [];

    public function resources($resources)
    {
        $this->resources = Collection::make($resources);
    }

    public function resource($route)
    {
        $resource = $this->resources->first(function ($resource) use ($route) {
            return $resource::$resourceRoute === $route;
        });

        return new $resource;
    }

    public function metrics($metrics)
    {
        $this->metrics = Collection::make($metrics);
    }

    public function metric($route)
    {
        $metric = $this->metrics->first(function ($metric) use ($route) {
            return $metric::$route === $route;
        });

        return new $metric;
    }
}
