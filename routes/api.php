<?php

use App\Http\Controllers\UserApiController;

Route::post('register-superadmin', [UserApiController::class, 'registerSuperadmin']);

Route::post('login', [UserApiController::class, 'login']);
Route::middleware('auth:api')->get('data', [UserApiController::class, 'getData']);
