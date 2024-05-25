<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Teachers\dashboard\CourseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/term',function()
{return 
    view('pages.term_of_use');
}
    )->name('term');
Route::get('/privacy',function(){return 
    view('pages.privacy_policy');
    })->name('privacy');

Auth::routes();
Route::get('/', 'HomeController@index')->name('selection');
Route::group(['namespace' => 'Auth'], function () {

    Route::get('/login/{type}', 'LoginController@loginForm')->middleware('guest')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/login/forgetpassword', 'LoginController@sendMail')->name('forgetPassword');
    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');
    Route::get('/register', [RegisterController::class,'index'])->middleware('guest')->name('register');
    
});

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {

    //==============================dashboard============================
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    //==============================Teachers============================
    Route::group(['namespace' => 'Teachers'], function () {
        Route::resource('Teachers', 'TeacherController');
    });


    //profile
    Route::resource('profile-admin', 'ProfileController');



    //==============================Students============================
    Route::group(['namespace' => 'Students'], function () {
        Route::resource('Students', 'StudentController');
    });
//course overview
Route::get('/course-overview', [CourseController::class,'course_overview'])->name('course-overview');
//course list
Route::get('/course-list',[CourseController::class,'course_list'])->name('course-list');
//delete course
Route::delete('/courses-admin/{courseId}', [CourseController::class,'delete'])->name('courses.delete');
//publish
Route::put('/course/toggle-publish/{id}', [CourseController::class,'togglePublish']);

});