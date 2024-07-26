<?php

use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\UserApiController;

Route::post('register-superadmin', [UserApiController::class, 'registerSuperadmin']);
Route::post('login', [UserApiController::class, 'login']);

//routes accessed by admin and super-admin only
Route::middleware(['auth:api', 'role.check:1,2'])->group(function () {
    Route::post('add-employee', [UserApiController::class, 'addEmployee']);
    Route::delete('/employees/{id}', [UserApiController::class, 'deleteEmployee']);

    Route::post('add-client', [UserApiController::class, 'addClient']);
    Route::post('update-clients/{id}', [UserApiController::class, 'updateClient']);
    Route::delete('/clients/{id}', [UserApiController::class, 'deleteClient']);

    Route::post('add-project', [ProjectApiController::class, 'addProject']);
    Route::delete('/projects/{id}', [ProjectApiController::class, 'deleteProject']);


});

//routes accessed by admin , supervisor and super-admin only
Route::middleware(['auth:api', 'role.check:1,2,3'])->group(function () {
    // Route::post('add-project', [ProjectApiController::class, 'addProject']);
});

//routes accessed by user, admin , supervisor and super-admin all
Route::middleware(['auth:api', 'role.check:1,2,3,4'])->group(function () {
    Route::post('get-employees', [UserApiController::class, 'getEmployees']);
    Route::post('update-profile', [UserApiController::class, 'updateProfile']);
    Route::get('get-clients', [UserApiController::class, 'getClients']);
    Route::get('get-projects', [ProjectApiController::class, 'getProjects']);
});
