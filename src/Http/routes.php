<?php

Route::prefix('resources/{resource}')->group(function () {
    Route::get('/', 'ResourceController@index');
});