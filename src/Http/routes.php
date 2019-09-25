<?php

Route::prefix('resources/{resource}')->group(function () {
    Route::get('/', 'ResourceController@index');
});

Route::prefix('metrics/{metric}')->group(function () {
    Route::get('/', 'MetricController@index');
});