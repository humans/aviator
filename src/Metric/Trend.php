<?php

namespace Artisan\Aviator\Metric;

use DateTime;
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
            return new Result(
                $query->get()->map(function ($premium) {
                    $premium->commission = $premium->commission / 100;

                    return $premium;
                })->pipe(function ($collection) {
                    return [
                        'labels' => $collection->pluck('month')->map(function ($month) {
                            return DateTime::createFromFormat('m', $month)->format('F');
                        }),
                        'series' => $collection->pluck('commission'),
                    ];
                })
            );
        }

        return new Result(
            $query->whereBetween('created_at', $this->range($request->period))->get()->map(function ($premium) {
                $premium->commission = $premium->commission / 100;

                return $premium;
            })->pipe(function ($collection) {
                return [
                    'labels' => $collection->pluck('month')->map(function ($month) {
                        return DateTime::createFromFormat('m', $month)->format('F');
                    }),
                    'series' => $collection->pluck('commission'),
                ];
            })
        );
    }
}
