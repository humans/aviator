<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Trend extends Metric
{
    public function sumByMonths(Request $request, $query, $field)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        $query
            ->selectRaw("SUM(`{$field}`) as {$field}, MONTH(`created_at`) as `month`")
            ->groupBy('month');


        if (! $request->has('period')) {
            return $query->get()->sum($field);
        }

        return $query->whereBetween('created_at', $this->range($request->period))->get()->sum($field);
    }
}
