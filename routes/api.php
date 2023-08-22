<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileTaskController;
use App\Http\Controllers\OpenTaskController;
use App\Http\Controllers\TestTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return abort(404);
    // return view('errors.404');  // incase you want to return view
}); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register/user', [AuthController::class, 'registerUser']);
Route::post('/auth/register/company', [AuthController::class, 'registerCompany']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/announcement/popular', [AnnouncementController::class, 'getPopularAnnouncement']);
Route::get('/announcement/{id}', [AnnouncementController::class, 'show']);
Route::get('/announcement/search/info', [AnnouncementController::class, 'getSearchAnnouncementInfo']);
Route::post('/announcement/search', [AnnouncementController::class, 'searchAnnouncement']);

Route::middleware(['auth:sanctum', 'ability:company'])->group(function () {
    Route::get('/company/test', [TestTaskController::class, 'index']);
    Route::post('/company/test', [TestTaskController::class, 'store']);
    Route::get('/company/test/{id}', [TestTaskController::class, 'show']);
    
    Route::get('/company/open-task', [OpenTaskController::class, 'index']);
    Route::post('/company/open-task', [OpenTaskController::class, 'store']);
    Route::get('/company/open-task/{id}', [OpenTaskController::class, 'show']);

    Route::get('/company/file-task', [FileTaskController::class, 'index']);
    Route::post('/company/file-task', [FileTaskController::class, 'store']);
    Route::get('/company/file-task/{id}', [FileTaskController::class, 'show']);

    Route::get('/company/announcement/info', [AnnouncementController::class, 'getCreateAnnoucementInfo']);
    Route::get('/company/announcement/earn-time', [AnnouncementController::class, 'getCreateAnnoucementEarnTimeInfo']);
    Route::get('/company/announcement/module', [AnnouncementController::class, 'getCreateAnnoucementModuleInfo']);
    Route::post('/company/announcement', [AnnouncementController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'ability:user'])->group(function () {
    Route::get('/user/announcement/{id}', [AnnouncementController::class, 'show']);
});