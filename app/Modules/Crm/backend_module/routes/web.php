<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    dd(\App\Src\BackendHelper::getOperations()->test());
    return 1;
});
