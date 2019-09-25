<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Contracts\Support\Responsable;

class Result implements Responsable
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function toResponse($request)
    {
        return $this->result;
    }
}
