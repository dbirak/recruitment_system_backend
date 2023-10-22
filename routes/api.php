<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CvTaskController;
use App\Http\Controllers\FileTaskController;
use App\Http\Controllers\OpenTaskController;
use App\Http\Controllers\TaskController;
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
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/announcement/popular', [AnnouncementController::class, 'getPopularAnnouncement']);
Route::get('/announcement/{id}', [AnnouncementController::class, 'show']);
Route::get('/announcement/search/info', [AnnouncementController::class, 'getSearchAnnouncementInfo']);
Route::post('/announcement/search', [AnnouncementController::class, 'searchAnnouncement']);
 
Route::get('/company-profile/{id}', [CompanyController::class, 'showCompanyProfileForUser']);
Route::post('/company-profile/{id}/announcement', [CompanyController::class, 'getCompanyAnnouncements']);
Route::post('/company-profile/{id}/comment', [CompanyController::class, 'getCompanyComments']);

Route::post('/company/search', [CompanyController::class, 'searchCompany']);

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
    Route::get('/company/announcement', [AnnouncementController::class, 'getCompanyAnnouncements']);
    Route::get('/company/announcement/{id}', [AnnouncementController::class, 'getCompanyAnnouncementById']);
    Route::post('/company/announcement/new-step', [AnnouncementController::class, 'beginNewStep']);
    Route::post('/company/announcement/end', [AnnouncementController::class, 'closeAnnouncement']);
    Route::post('/company/announcement/mail', [AnnouncementController::class, 'sendMail']);
    
    Route::get('/company/application/{id}', [ApplicationController::class, 'getUsersByStep']);
    Route::post('/company/application/managment', [ApplicationController::class, 'managementUsersInStep']);
    Route::post('/company/application/task', [ApplicationController::class, 'getUserApplication']);

    Route::get('/company/answer/cv-task/{fileName}', [CvTaskController::class, 'getCvAnswer']);
    Route::get('/company/answer/file-task/{fileName}', [FileTaskController::class, 'getFileAnswer']);

    Route::get('/company/profile', [CompanyController::class, 'getCompanyProfile']);
    Route::post('/company/profile', [CompanyController::class, 'update']);

    Route::get('/company/statistics', [CompanyController::class, 'getStatistics']);

});

Route::middleware(['auth:sanctum', 'ability:user'])->group(function () {
    Route::get('/user/announcement/{id}', [AnnouncementController::class, 'showApplicationInfo']);    
    Route::post('/user/announcement/task-info', [AnnouncementController::class, 'getTaskUserInfo']);    
    
    Route::post('/user/application/cv', [ApplicationController::class, 'storeCvTaskAnswer']);
    
    Route::post('/user/task/info', [TaskController::class, 'getTaskInfo']);
    Route::post('/user/task/answer', [TaskController::class, 'storeTaskAnswer']);
    
    Route::post('/user/company-profile/{id}/comment', [CompanyController::class, 'getCompanyCommentsForUsers']);
    Route::post('/user/company-profile/comment', [CompanyController::class, 'storeCompanyComment']);
    Route::put('/user/company-profile/comment/{id}', [CompanyController::class, 'updateCompanyComment']);
    Route::delete('/user/company-profile/comment/{id}', [CompanyController::class, 'destroyCompanyComment']);
});