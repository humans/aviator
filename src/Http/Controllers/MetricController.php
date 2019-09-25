<?php

namespace Artisan\Aviator\Http\Controllers;

use Facades\Artisan\Aviator\Aviator;
use Illuminate\Http\Request;

class MetricController
{
    public function index(Request $request)
    {
        return [
            'result' => Aviator::metric(
                $request->route('metric')
            )->calculate($request)
        ];
    }
}
