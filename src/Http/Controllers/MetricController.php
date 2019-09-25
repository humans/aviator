<?php

namespace Artisan\Aviator\Http\Controllers;

use DateTime;
use Facades\Artisan\Aviator\Aviator;
use Illuminate\Http\Request;

class MetricController
{
    public function index(Request $request)
    {
        return Aviator::metric($request->route('metric'))
            ->calculate($request)
            ->pipe(function ($collection) {
                return [
                    'x' => $collection->pluck('month')->map(function ($month) {
                        return DateTime::createFromFormat('m', $month)->format('F');
                    }),
                    'y' => $collection->pluck('commission'),
                ];
            });
    }
}
