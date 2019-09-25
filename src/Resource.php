<?php

namespace Artisan\Aviator;

class Resource
{
    public function model()
    {
        return new static::$model;
    }

    public function paginate()
    {
        return $this->model()->paginate();
    }
}
