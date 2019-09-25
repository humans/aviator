<?php

namespace Artisan\Aviator\Http\Controllers;

use Facades\Artisan\Aviator\Aviator;
use Artisan\Aviator\JsonResource;

class ResourceController
{
    public function index($resource)
    {
        return JsonResource::collection(
            Aviator::resource($resource)->paginate()
        );
    }
}
