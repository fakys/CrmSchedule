<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(\App\Src\BackendHelper::getModule('backend_module')::getNameModule());
    return 1;
});
