<?php

namespace Artisan\Aviator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Resource
{
    public static $search = [];

    public static function query()
    {
        return (new static::$model)->query();
    }

    public static function search($keyword)
    {
        return static::query()->where(function (Builder $query) use ($keyword) {
            foreach (Arr::wrap(static::$search) as $attribute) {
                $query->when(
                    Str::contains($attribute, '.'),

                    function (Builder $query) use ($attribute, $keyword) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);
                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $keyword) {
                            $query->where($relationAttribute, 'LIKE', "%{$keyword}%");
                        });
                    },

                    function (Builder $query) use ($attribute, $keyword) {
                        $table = $query->getModel()->getTable();

                        $query->orWhere("{$table}.{$attribute}", 'LIKE', "%{$keyword}%");
                    }
                );
            }
        });
    }

    public function fields()
    {
        return '*';
    }

    public function paginate()
    {
        $query = Request::has('q')
            ? static::search(Request::input('q'))
            : static::query();

        return $query->select($this->fields())->paginate();
    }
}
