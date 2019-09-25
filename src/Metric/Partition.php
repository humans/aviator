<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Partition extends Metric
{
    public function count(Request $request, $query, $field)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        $query->selectRaw("{$field}, COUNT({$field}) as count")->groupBy($field);

        if (! $request->has('period')) {
            return new Result(
                $query->get()->pipe(function ($collection) use ($field) {
                    return [
                        'labels' => $collection->pluck($field),
                        'series' => $collection->pluck('count'),
                    ];
                })
            );
        }

        return new Result(
            $query->whereBetween('created_at', $this->range($request->period))->get()->pipe(function ($collection) use ($field) {
                return [
                    'labels' => $collection->pluck($field),
                    'series' => $collection->pluck('count'),
                ];
            })
        );
    }
}
