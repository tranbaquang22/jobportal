<?php

use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Candidate\JobController;
use App\Http\Controllers\HR\CanidateController;
use App\Http\Controllers\HR\InterviewController;
use App\Http\Controllers\HR\RecruitmentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Manager\CampaignController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthManager;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'home']);
Route::get('/jobs', [JobController::class, 'list_jobs']);
Route::post('/jobs', [JobController::class, 'search_jobs']);
Route::get('/jobs/{id}', [JobController::class, 'job_detail'])->where('id', '[0-9]+');
Route::post('/jobs/{id}', [JobController::class, 'apply'])->where('id', '[0-9]+');

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [SessionsController::class, 'forgot_password']);
    Route::post('/login/forgot-password', [SessionsController::class, 'post_forgot_password']);
});

Route::prefix('company')->middleware(['auth'])->group(function () {
    // Only-admin routes
    Route::middleware([AuthAdmin::class])->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'list_users']);
            Route::get('create', [UserController::class, 'create']);
            Route::post('create', [UserController::class, 'post_create']);
            Route::get('update/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
            Route::post('update/{id}', [UserController::class, 'post_update'])->where('id', '[0-9]+');
            Route::get('delete/{id}', [UserController::class, 'delete'])->where('id', '[0-9]+');
        });
    });

    Route::prefix('campaigns')->middleware([AuthManager::class])->group(function () {
        Route::get('/', [CampaignController::class, 'list_campaigns']);
        Route::get('create', [CampaignController::class, 'create']);
        Route::post('create', [CampaignController::class, 'post_create']);
        Route::post('add-job', [CampaignController::class, 'add_job']);
        Route::post('remove-job', [CampaignController::class, 'remove_job']);
        Route::get('/{id}', [CampaignController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/{id}/update', [CampaignController::class, 'post_update'])->where('id', '[0-9]+');
        Route::get('{id}/delete', [CampaignController::class, 'delete'])->where('id', '[0-9]+');
        Route::get('{id}/recruitment-news', [CampaignController::class, 'list_recruitment_news'])->where('id', '[0-9]+');
    });

    Route::prefix('recruitment-news')->group(function () {
        Route::get('/', [RecruitmentController::class, 'list_recruitment_news']);
        Route::get('create', [RecruitmentController::class, 'create']);
        Route::post('create', [RecruitmentController::class, 'post_create']);
        Route::get('update/{id}', [RecruitmentController::class, 'update'])->where('id', '[0-9]+');
        Route::post('update/{id}', [RecruitmentController::class, 'post_update'])->where('id', '[0-9]+');
        Route::get('delete/{id}', [RecruitmentController::class, 'delete'])->where('id', '[0-9]+');
        Route::get('/{id}/hide', [RecruitmentController::class, 'hide'])->where('id', '[0-9]+');
        Route::get('/{id}/show', [RecruitmentController::class, 'show'])->where('id', '[0-9]+');
    });

    Route::prefix('applications')->group(function () {
        Route::get('/', [CanidateController::class, 'list_applications']);
        Route::post('/', [CanidateController::class, 'search_applications']);
        Route::get('/create', [CanidateController::class, 'create']);
        Route::post('/create', [CanidateController::class, 'post_create']);
        Route::get('/{id}', [CanidateController::class, 'show']);
        Route::post('/{id}', [CanidateController::class, 'update']);
        Route::get('/{id}/delete', [CanidateController::class, 'delete'])->where('id', '[0-9]+');
        Route::get('/{id}/recruitment-process', [CanidateController::class, 'show_recruiment_process'])->where('id', '[0-9]+');
        Route::post('/{id}/recruitment-process/comment', [CanidateController::class, 'post_comment'])->where('id', '[0-9]+');
        Route::get('/{id}/recruitment-process/update-status', [CanidateController::class, 'update_status'])->where('id', '[0-9]+');
    });

    Route::prefix('interviews')->group(function () {
        Route::get('/', [InterviewController::class, 'list_interviews']);
        Route::post('/', [InterviewController::class, 'search_interviews']);
        Route::get('create', [InterviewController::class, 'create']);
        Route::post('create', [InterviewController::class, 'post_create']);
        Route::get('create/select-candidate', [InterviewController::class, 'select_candidate']);
        Route::post('create/select-candidate', [InterviewController::class, 'post_select_candidate']);
        Route::get('/{id}', [InterviewController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/{id}/update', [InterviewController::class, 'post_update'])->where('id', '[0-9]+');
        Route::get('/{id}/delete', [InterviewController::class, 'delete'])->where('id', '[0-9]+');
        Route::get('/{id}/update-candidates', [InterviewController::class, 'update_candidate'])->where('id', '[0-9]+');
        Route::post('/{id}/update-candidates', [InterviewController::class, 'post_update_candidate'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/interviewer', [MailController::class, 'update_interviewer_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/interviewer', [MailController::class, 'post_update_interviewer_mail'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/candidate-online', [MailController::class, 'update_online_candidate_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/candidate-online', [MailController::class, 'post_update_online_candidate_mail'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/candidate-offline', [MailController::class, 'update_offline_candidate_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/candidate-offline', [MailController::class, 'post_update_offline_candidate_mail'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/candidate-passed', [MailController::class, 'update_passed_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/candidate-passed', [MailController::class, 'post_update_passed_mail'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/candidate-passed-final', [MailController::class, 'update_final_passed_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/candidate-passed-final', [MailController::class, 'post_update_final_passed_mail'])->where('id', '[0-9]+');

        Route::get('/{id}/mail-setting/candidate-failed', [MailController::class, 'update_failed_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail-setting/candidate-failed', [MailController::class, 'post_update_failed_mail'])->where('id', '[0-9]+');

        Route::post('/{id}/mail/interviewer', [InterviewController::class, 'send_mai_to_interviewers'])->where('id', '[0-9]+');
        Route::post('/{id}/mail/candidate-online', [InterviewController::class, 'send_mail_to_online_candidates'])->where('id', '[0-9]+');
        Route::post('/{id}/mail/candidate-offline', [InterviewController::class, 'send_mail_to_offline_candidates'])->where('id', '[0-9]+');
        Route::post('/{id}/mail/candidate-passed', [InterviewController::class, 'send_passed_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail/candidate-passed-final', [InterviewController::class, 'send_final_passed_mail'])->where('id', '[0-9]+');
        Route::post('/{id}/mail/candidate-failed', [InterviewController::class, 'send_failed_mail'])->where('id', '[0-9]+');
    });

    Route::get('/profile', [ProfileController::class, 'update']);
    Route::post('/profile', [ProfileController::class, 'post_update']);
    Route::get('/profile/change-password', [ProfileController::class, 'change_password']);
    Route::post('/profile/change-password', [ProfileController::class, 'post_change_password']);
    Route::get('/logout', [SessionsController::class, 'destroy']);
});
