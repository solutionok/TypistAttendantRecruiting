<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * frontend routes
 */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/home/verified', 'HomeController@verified');
Route::get('/home/welcome', 'HomeController@welcome');

Auth::routes();
Auth::routes(['verify' => true]);

//Route::get('/home/apply', 'HomeController@apply');
//Route::post('/home/doapplication', 'HomeController@doapplication');
Route::get('/jobs', 'JobsController@index');
Route::get('/jobs/apply', 'JobsController@apply')->middleware(['auth','verified']);
Route::post('/jobs/saveapply', 'JobsController@saveapply')->middleware(['auth','verified']);
Route::get('/jobs/applyresult', 'JobsController@applyresult')->middleware(['auth','verified']);
Route::post('/jobs/offerinfo', 'JobsController@offerinfo')->middleware(['auth','verified']);
Route::get('/jobs/traning', 'JobsController@traning')->middleware(['auth','verified']);
Route::post('/jobs/savetraning', 'JobsController@savetraning')->middleware(['auth','verified']);
Route::get('/jobs/traningresult', 'JobsController@traningresult')->middleware(['auth','verified']);
//Route::get('/register/verify', 'Auth\RegisterController@verify');

/**
 * Backend routes
 */
//admin dashboard
Route::get('/admin', 'Admin\JobController@index')->middleware(['admin','auth','verified']);
//Route::get('/admin', 'Admin\DashboardController@index')->middleware(['admin']);
Route::get('/admin/dashboard', 'Admin\DashboardController@index')->middleware(['admin','auth','verified']);

//admin settings
Route::get('/admin/settings', 'Admin\SettingsController@index');
Route::post('/admin/settings/account', 'Admin\SettingsController@account');
Route::post('/admin/settings/password', 'Admin\SettingsController@password');
Route::post('/admin/settings/checkpass', 'Admin\SettingsController@checkpass');

//test manage
Route::get('/admin/job', 'Admin\JobController@index')->middleware(['assessor']);
Route::post('/admin/job', 'Admin\JobController@saveJob')->middleware(['assessor']);
Route::get('/admin/job/delete', 'Admin\JobController@deleteJob')->middleware(['assessor']);
Route::get('/admin/job/toggle', 'Admin\JobController@toggle')->middleware(['assessor']);
Route::get('/admin/job/{id}', 'Admin\JobController@getJob')->middleware(['assessor']);

//quiz manage
Route::get('/admin/quiz', 'Admin\QuizController@index')->middleware(['assessor']);;
Route::post('/admin/quiz', 'Admin\QuizController@saveQuiz')->middleware(['assessor']);
Route::get('/admin/quiz/getquiz/{quizid}', 'Admin\QuizController@getQuiz')->middleware(['assessor']);
Route::get('/admin/quiz/delete', 'Admin\QuizController@deleteQuiz')->middleware(['assessor']);
Route::get('/admin/quiz/moveq/{id}', 'Admin\QuizController@moveq')->middleware(['assessor']);

//review test
Route::get('/admin/review', 'Admin\ReviewController@index');
Route::get('/admin/review/exportcsv', 'Admin\ReviewController@exportcsv');
Route::get('/admin/review/{id}/{step?}', 'Admin\ReviewController@viewTest');
Route::post('/admin/review/historyinfo', 'Admin\ReviewController@historyinfo');
Route::post('/admin/review/evaluate', 'Admin\ReviewController@setGrade')->middleware(['assessor']);
Route::post('/admin/review/delete', 'Admin\ReviewController@removeHistory')->middleware(['assessor']);

//assessor manage
Route::get('/admin/assessor', 'Admin\AssessorController@index')->middleware(['admin']);
Route::post('/admin/assessor', 'Admin\AssessorController@saveAssessor')->middleware(['admin']);
Route::post('/admin/assessor/remove', 'Admin\AssessorController@remove')->middleware(['admin']);
Route::post('/admin/assessor/emailcheck', 'Admin\AssessorController@emailcheck')->middleware(['admin']);

//applicant manage
Route::get('/admin/applicant', 'Admin\ApplicantController@index')->middleware(['assessor']);
Route::get('/admin/applicant/view', 'Admin\ApplicantController@view')->middleware(['assessor']);
Route::post('/admin/applicant/delete', 'Admin\ApplicantController@remove')->middleware(['assessor']);
Route::post('/admin/applicant/save', 'Admin\ApplicantController@save')->middleware(['assessor']);
Route::post('/admin/applicant/emailcheck', 'Admin\ApplicantController@emailcheck')->middleware(['assessor']);
Route::post('/admin/applicant/bulkadd', 'Admin\ApplicantController@bulkadd')->middleware(['assessor']);
Route::post('/admin/applicant/assign', 'Admin\ApplicantController@assignTest')->middleware(['assessor']);
Route::post('/admin/applicant/uploadcv', 'Admin\ApplicantController@uploadcv')->middleware(['assessor']);
Route::get('/admin/applicant/downcsv', 'Admin\ApplicantController@downcsv')->middleware(['assessor']);
Route::post('/admin/applicant/assessors/{interivewId}', 'Admin\ApplicantController@assessors')->middleware(['assessor']);
Route::get('/admin/applicant/invitmail/{id}', 'Admin\ApplicantController@invitmail');
Route::get('/admin/applicant/invitmailbluk', 'Admin\ApplicantController@invitmailbluk');
Route::get('/admin/applicant/rejectmail/{id}', 'Admin\ApplicantController@rejectmail');
Route::get('/admin/applicant/rejectmailbluk', 'Admin\ApplicantController@rejectmailbluk');


Route::get('logout', function() {
    Auth::logout();
    return redirect('/');
});
Auth::routes();
