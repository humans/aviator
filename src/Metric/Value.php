<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Value extends Metric
{
    public function count(Request $request, $query)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return new Result(
                $query->count()
            );
        }

        return new Result(
            $query->whereBetween('created_at', $this->range($request->period))->count()
        );
    }

    public function sum(Request $request, $query, $field)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return new Result(
                $query->get()->sum($field)
            );
        }

        return new Result(
            $query->whereBetween('created_at', $this->range($request->period))->get()->sum($field)
        );
    }
}
