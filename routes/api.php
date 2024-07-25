<?php

use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\UserApiController;

Route::post('register-superadmin', [UserApiController::class, 'registerSuperadmin']);
Route::post('login', [UserApiController::class, 'login']);

//routes accessed by admin and super-admin only
Route::middleware(['auth:api', 'role.check:1,2'])->group(function () {
    Route::post('add-employee', [UserApiController::class, 'addEmployee']);
    Route::post('add-client', [UserApiController::class, 'addClient']);
    Route::get('get-clients', [UserApiController::class, 'getClients']);
    Route::post('add-project', [ProjectApiController::class, 'addProject']);
});
