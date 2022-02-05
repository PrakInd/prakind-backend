<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ApplicantFileController;

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
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('/{id}/upload-image', [UserController::class, 'uploadImage']);
        Route::get('', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::patch('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::post('/{id}', [UserController::class, 'resetPassword']);
    });

    Route::resource('roles', RolesController::class);
    Route::resource('groups', GroupController::class);

    Route::prefix('profiles')->group(function() {
        Route::post('/{id}/upload/{document}', [ProfileController::class, 'uploadDocument']);
        Route::get('', [ProfileController::class, 'index']);
        Route::post('', [ProfileController::class, 'store']);
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::patch('/{id}', [ProfileController::class, 'update']);
        Route::delete('/{id}', [ProfileController::class, 'destroy']);
    });

    Route::prefix('companies')->group(function() {
        Route::post('/{id}/upload-logo', [CompanyController::class, 'uploadLogo']);
        Route::get('', [CompanyController::class, 'index']);
        Route::post('', [CompanyController::class, 'store']);
        Route::get('/{id}', [CompanyController::class, 'show']);
        Route::patch('/{id}', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'destroy']);
    });

    Route::resource('vacancies', VacancyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('institutions', InstitutionController::class);
    
    Route::prefix('applications')->group(function() {
        Route::post('/{id}/upload-certificate', [ApplicationController::class, 'uploadCertificate']);
        Route::get('', [ApplicationController::class, 'index']);
        Route::post('', [ApplicationController::class, 'store']);
        Route::get('/{id}', [ApplicationController::class, 'show']);
        Route::patch('/{id}', [ApplicationController::class, 'update']);
        Route::delete('/{id}', [ApplicationController::class, 'destroy']);
    });

    Route::prefix('applicant-files')->group(function() {
        Route::post('/{id}/upload/{document}', [ApplicantFileController::class, 'uploadDocument']);
        Route::get('', [ApplicantFileController::class, 'index']);
        Route::post('', [ApplicantFileController::class, 'store']);
        Route::get('/{id}', [ApplicantFileController::class, 'show']);
        Route::delete('/{id}', [ApplicantFileController::class, 'destroy']);
    });
});
