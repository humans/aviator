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

    public function resource($slug)
    {
        $resource = $this->resources->first(function ($resource) use ($slug) {
            return $resource::$slug === $slug;
        });

        return new $resource;
    }
}
