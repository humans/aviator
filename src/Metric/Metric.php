<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Support\Carbon;

class Metric
{
    protected $ranges = [
        'MTD' => 30,
        'QTD' => 91,
        'YTD' => 365,
    ];

    public function range($range)
    {
        if (array_key_exists($range, $this->ranges)) {
            $range = $this->ranges[$range];
        }

        return [Carbon::now()->subDays($range), Carbon::now()];
    }
}
