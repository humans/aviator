<?php

namespace Artisan\Aviator\Http\Controllers;

use Facades\Artisan\Aviator\Aviator;
use Illuminate\Http\Request;

class MetricController
{
    public function index(Request $request, $metric)
    {
        return ['result' => Aviator::metric($metric)->calculate($request)];
    }
}
