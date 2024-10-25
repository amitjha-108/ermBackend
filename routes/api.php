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
    Route::delete('/delete-message/{id}', [UserApiController::class, 'deleteMessage']);

    Route::delete('tasks/{id}', [ProjectApiController::class, 'deleteTask']);
    Route::post('/project-wise-team', [ProjectApiController::class, 'projectWiseTeam']);

    Route::post('get-user-report', [UserApiController::class, 'getUserReport']);//adhura
    Route::post('get-user-datewise-report', [UserApiController::class, 'userDateWiseReport']);//adhura

    Route::post('/employees-monthly-attendance', [UserApiController::class, 'getEmployeesMonthlyAttendance']);
    Route::post('/employees-monthly-performance', [UserApiController::class, 'getEmployeesPerformance']);
    Route::post('/rate-employee', [UserApiController::class, 'rateEmployee']);
    Route::post('/assign-tl-to-project', [UserApiController::class, 'assignTLtoProject']);
    Route::get('/list-tl', [UserApiController::class, 'listTL']);

});


//routes accessed by user(4), admin(2) , and super-admin(1) all
Route::middleware(['auth:api', 'role.check:1,2,4'])->group(function () {
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
    Route::post('/create-task', [ProjectApiController::class, 'createTask']);
    Route::post('/edit-task/{id}', [ProjectApiController::class, 'editTask']);
    Route::post('/edit-task-status/{id}', [ProjectApiController::class, 'editTaskStatus']);
    Route::get('/list-all-task', [ProjectApiController::class, 'listAllTasks']);
    Route::post('/list-team-members', [ProjectApiController::class, 'listTeamMembers']);

    Route::get('/get-message', [UserApiController::class, 'getMessage']);
});
