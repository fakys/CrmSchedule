<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(\App\Src\BackendHelper::getFullModule());
    return 1;
});
