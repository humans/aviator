<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Value
{
    protected $ranges = [
        'MTD' => 30,
        'QTD' => 91,
        'YTD' => 365,
    ];

    public function count(Request $request, $query)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return $query->count();
        }

        return $query->whereBetween('created_at', $this->range($request->period))->count();
    }

    public function range($range)
    {
        if (array_key_exists($range, $this->ranges)) {
            $range = $this->ranges[$range];
        }

        return [Carbon::now()->subDays($range), Carbon::now()];
    }

    public function sum(Request $request, $query, $field)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return $query->get()->sum($field);
        }

        return $query->whereBetween('created_at', $this->range($request->period))->get()->sum($field);
    }
}
