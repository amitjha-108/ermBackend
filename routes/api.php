<?php

use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\UserApiController;

Route::post('register-superadmin', [UserApiController::class, 'registerSuperadmin']);
Route::post('login', [UserApiController::class, 'login']);

//routes accessed by admin and super-admin only
Route::middleware(['auth:api', 'role.check:1,2'])->group(function () {
    Route::post('add-employee', [UserApiController::class, 'addEmployee']);
    Route::post('update-employees/{id}', [UserApiController::class, 'updateEmployee']);
    Route::get('/employees/{id}', [UserApiController::class, 'getEmployeeById']);
    Route::delete('/employees/{id}', [UserApiController::class, 'deleteEmployee']);

    Route::post('add-client', [UserApiController::class, 'addClient']);
    Route::post('update-clients/{id}', [UserApiController::class, 'updateClient']);
    Route::delete('/clients/{id}', [UserApiController::class, 'deleteClient']);

    Route::post('add-project', [ProjectApiController::class, 'addProject']);
    Route::post('update-projects/{id}', [ProjectApiController::class, 'updateProject']);
    Route::get('/projects/{id}', [ProjectApiController::class, 'getProjectById']);
    Route::delete('/projects/{id}', [ProjectApiController::class, 'deleteProject']);

    Route::get('/list-leave-applications', [UserApiController::class, 'getAllLeaves']);
    Route::post('/update-leave-status/{leaveId}', [UserApiController::class, 'updateLeaveStatus']);

    Route::post('/send-message/{id}', [UserApiController::class, 'sendMessageToUser']);
    Route::post('/send-message-to-all', [UserApiController::class, 'sendMessageToAllUsers']);



});

//routes accessed by admin , supervisor and super-admin only
Route::middleware(['auth:api', 'role.check:1,2,3'])->group(function () {
    Route::post('/employees-monthly-attendance', [UserApiController::class, 'getEmployeesMonthlyAttendance']);
    Route::post('/employees-monthly-performance', [UserApiController::class, 'getEmployeesPerformance']);
    Route::post('/rate-employee', [UserApiController::class, 'rateEmployee']);
    Route::get('/list-all-task', [ProjectApiController::class, 'listAllTasks']);
});

//routes accessed by user, admin , supervisor and super-admin all
Route::middleware(['auth:api', 'role.check:1,2,3,4'])->group(function () {
    Route::post('get-employees', [UserApiController::class, 'getEmployees']);
    Route::post('update-profile', [UserApiController::class, 'updateProfile']);
    Route::get('get-clients', [UserApiController::class, 'getClients']);
    Route::get('get-projects', [ProjectApiController::class, 'getProjects']);
    Route::post('/apply-leave', [UserApiController::class, 'applyLeave']);
    Route::get('/my-leave-applications', [UserApiController::class, 'getUserLeaves']);
    Route::post('/make-attendance', [UserApiController::class, 'makeAttendance']);
    Route::post('/my-monthly-attendance', [UserApiController::class, 'getMyMonthlyAttendance']);
    Route::post('/my-monthly-performance', [UserApiController::class, 'getMyPerformance']);
    Route::get('/my-analytics', [UserApiController::class, 'getAnalytics']);
    Route::get('/my-analytics', [UserApiController::class, 'getAnalytics']);
    Route::get('/list-own-task', [ProjectApiController::class, 'listOwnTasks']);
});
