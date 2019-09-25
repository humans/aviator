<?php

namespace Artisan\Aviator\Http\Controllers;

use Facades\Artisan\Aviator\Aviator;

class ResourceController
{
    public function index($resource)
    {
        return Aviator::resource($resource)->paginate();
    }
}
