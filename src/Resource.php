<?php

namespace Artisan\Aviator;

use Illuminate\Support\Facades\Request;

class Resource
{
    use Concerns\Searchable;

    public static $search = [];

    public static function query()
    {
        return (new static::$model)->query();
    }

    public function fields()
    {
        return '*';
    }

    public function paginate()
    {
        return static::search(Request::input('q'))
            ->select($this->fields())
            ->paginate();
    }
}
