<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(\App\Src\BackendHelper::getModule('backend_module'));
    return 1;
});
