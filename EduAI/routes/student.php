<?php

use App\Http\Controllers\Students\dashboard\CourseController;
use App\Http\Controllers\Teachers\dashboard\AnswerController;
use App\Http\Controllers\Teachers\dashboard\QuizController;
use App\Http\Controllers\Teachers\dashboard\ResultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student']
    ], function () {

    //==============================dashboard============================
    Route::get('/student/dashboard', function () {
        return view('pages.Students.dashboard');
    })->name('dashboard.Students');

    Route::group(['namespace' => 'Students\dashboard'], function () {
        Route::resource('profile-student', 'ProfileController');
          //---------------courses---------
    Route::resource('Courses','CourseController');
    
    Route::get('/Courses/editable/{id}','CourseController@editable')->name('Courses.editable');
    Route::get('/Courses/show/{id}','CourseController@show')->name('Courses.show');

    Route::get('/Courses/Add/{id}','CourseController@add')->name('Courses.add');
    Route::get('/Courses/Remove/{id}','CourseController@remove')->name('Courses.remove');

    Route::get('/my-new-courses', 'CourseController@myNewCourses')->name('my-new-courses');
    Route::get('/my-courses', 'CourseController@myCourses')->name('my-courses');
    Route::get('/my-completed-courses', 'CourseController@myCompletedCourses')->name('my-completed-courses');
    Route::get('/give-quiz/{id}',[QuizController::class,'joinQuiz'])->name('join.quiz');
    Route::post('/store-answer',[AnswerController::class,'store'])->name('store.answer');
    Route::get('/show/{current_id}',[ResultController::class,'index'])->name('shows');

    Route::post('/chat', [ChatController::class, 'chat']);
    Route::post('/StartStudentchat', [ChatController::class, 'startChat']);

    Route::get('download_book/{filename}',[CourseController::class,'download'])->name('downloadBook');
    Route::get('/give-quiz/{id}',[QuizController::class,'joinQuiz'])->name('join.quiz');
//check
Route::post('/updateCheckbox', 'CourseController@updateCheckbox')->name('updateCheckbox');
Route::post('/updateCheckedItemsCounter', 'CourseController@updateCheckedItemsCounter');
Route::post('/updateClickCounter','CourseController@updateClickCounter')->name('updateClickCounter');   
});



});