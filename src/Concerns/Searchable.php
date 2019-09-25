<?php

namespace Artisan\Aviator\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Searchable
{
    public static function search($keyword)
    {
        return static::query()->where(function (Builder $query) use ($keyword) {
            foreach (Arr::wrap(static::$search) as $attribute) {
                $query->when(
                    Str::contains($attribute, '.'),
                    static::searchWithinRelations($attribute, $keyword),
                    static::searchWithoutRelations($attribute, $keyword)
                );
            }
        });
    }

    private static function searchWithinRelations($attribute, $keyword)
    {
        return function (Builder $query) use ($attribute, $keyword) {
            [$relationName, $relationAttribute] = explode('.', $attribute);
            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $keyword) {
                $query->where($relationAttribute, 'LIKE', "%{$keyword}%");
            });
        };
    }

    private static function searchWithoutRelations($attribute, $keyword)
    {
        return function (Builder $query) use ($attribute, $keyword) {
            $table = $query->getModel()->getTable();

            $query->orWhere("{$table}.{$attribute}", 'LIKE', "%{$keyword}%");
        };
    }
}
