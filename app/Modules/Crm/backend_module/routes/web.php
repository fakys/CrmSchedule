<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $repos = new \App\Src\modules\repository\Repository();
    dd($repos->getFullRepositories());
    return 1;
});
