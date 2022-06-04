<?php

use Illuminate\Support\Facades\Route;

Route::get('company/store', [App\Http\Controllers\Tenanat\CompanyController::class, 'store']);

Route::get('/tenant', function () {
    return 'tenant';
});
