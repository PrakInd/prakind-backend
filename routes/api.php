<?php

use App\Http\Controllers\ApplicantFileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth'])->group(function(){
    Route::prefix('users')->group(function() {
        Route::get('', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        // Route::post('', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']); // nge bug
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::get('{id}/reset', [UserController::class, 'resetPassword']); // belum bisa
    });

    Route::prefix('profiles')->group(function() {
        Route::get('', [ProfileController::class, 'index']);
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::post('', [ProfileController::class, 'store']);
        Route::put('/{id}', [ProfileController::class, 'update']);
        Route::delete('/{id}', [ProfileController::class, 'destroy']);
    });

    Route::prefix('applicant-files')->group(function() {
        Route::get('', [ApplicantFileController::class, 'index']);
        Route::get('/{id}', [ApplicantFileController::class, 'show']);
        Route::post('', [ApplicantFileController::class, 'store']);
        Route::put('/{id}', [ApplicantFileController::class, 'update']);
        Route::delete('/{id}', [ApplicantFileController::class, 'destroy']);
    });

    Route::prefix('groups')->group(function() {
        Route::get('', [GroupController::class, 'index']);
        Route::get('/{id}', [GroupController::class, 'show']);
        Route::post('', [GroupController::class, 'store']);
        Route::put('/{id}', [GroupController::class, 'update']);
        Route::delete('/{id}', [GroupController::class, 'destroy']);
    });

    Route::prefix('applications')->group(function() {
        Route::get('', [ApplicationController::class, 'index']);
        Route::get('/{id}', [ApplicationController::class, 'show']);
        Route::post('', [ApplicationController::class, 'store']);
        Route::put('/{id}', [ApplicationController::class, 'update']);
        Route::delete('/{id}', [ApplicationController::class, 'destroy']);
    });

    Route::prefix('institutions')->group(function() {
        Route::get('', [InstitutionController::class, 'index']);
        // Route::get('/{id}', [InstitutionController::class, 'show']);
        Route::post('', [InstitutionController::class, 'store']);
        Route::put('/{id}', [InstitutionController::class, 'update']);
        Route::delete('/{id}', [InstitutionController::class, 'destroy']);
    });

    Route::prefix('departments')->group(function() {
        Route::get('', [DepartmentController::class, 'index']);
        // Route::get('/{id}', [DepartmentController::class, 'show']);
        Route::post('', [DepartmentController::class, 'store']);
        Route::put('/{id}', [DepartmentController::class, 'update']);
        Route::delete('/{id}', [DepartmentController::class, 'destroy']);
    });

    Route::prefix('companies')->group(function() {
        Route::get('', [CompanyController::class, 'index']);
        Route::get('/{id}', [CompanyController::class, 'show']);
        Route::post('', [CompanyController::class, 'store']);
        Route::put('/{id}', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'destroy']);
    });

    Route::prefix('vacancies')->group(function() {
        Route::get('', [VacancyController::class, 'index']);
        Route::get('/{id}', [VacancyController::class, 'show']);
        Route::post('', [VacancyController::class, 'store']);
        Route::put('/{id}', [VacancyController::class, 'update']);
        Route::delete('/{id}', [VacancyController::class, 'destroy']);
    });
});
