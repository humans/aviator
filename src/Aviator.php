<?php

namespace Artisan\Aviator;

use Illuminate\Support\Collection;

class Aviator
{
    protected $resources = [];

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
}
