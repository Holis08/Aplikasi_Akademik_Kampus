<?php

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CourseLecturerController;
use App\Http\Controllers\StudentController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });

    Route::apiResource('student', StudentController::class);
    Route::apiResource('course', CourseController::class);
    Route::apiResource('enrollment', EnrollmentController::class);
    Route::apiResource('lecturer', LecturerController::class);
    Route::apiResource('course_lecturers', CourseLecturerController::class);

});





