<?php



use App\Http\Controllers\Teachers\dashboard\CourseController;
use App\Http\Controllers\Teachers\dashboard\ItemController;
use App\Http\Controllers\Teachers\dashboard\PostController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Teachers\dashboard\QuestionController;
use App\Http\Controllers\Teachers\dashboard\QuizController;
use App\Http\Controllers\Teachers\dashboard\ResultController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Teachers\dashboard\ChatController;


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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        return view('pages.Teachers.dashboard.dashboard');
    });

    Route::group(['namespace' => 'Teachers\dashboard'], function () {

     Route::get('profile', 'ProfileController@index')->name('profile.show');


     Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');

     ////////////
     Route::resource('courses', 'CourseController');
     Route::resource('lesson', 'LessonController');
     Route::get('/lesson/editable/{id}', 'LessonController@editable')->name('lesson.editable');
     
     // routes/web.php
     Route::post('/save-order', 'ItemController@saveOrder')->name('save-order');
     Route::get('/create_Youtube_URL/{current_id}', 'ItemController@create_Youtube_URL')->name('Item.create_youtube_url');
     Route::post('/save-url', 'ItemController@storeURL')->name('Item.storeURL');
     //  Route::post('Upload_attachment',[CourseController::class,'Upload_attachment'])->name('Upload_attachment');
      Route::resource('Item', 'ItemController');
      Route::get('edit/{id}/{current_id}',[ItemController::class,'edit'])->name('Item.edit');
      Route::get('create/{current_id}',[ItemController::class,'create'])->name('Item.create');


      Route::resource('Section', 'SectionController');
      Route::post('/sections', 'SectionController@store')->name('section.store');
      Route::post('/sections/update-order', 'SectionController@updateOrder')->name('Section.updateOrder');

      Route::get('download_file/{filename}', 'ItemController@downloadAttachment')->name('downloadAttachment');
//WYSIWYG
// Route::get('/',[PostController::class,'index']);
Route::get('create_post/{id}',[PostController::class,'create'])->name('WYSIWYG.create');
Route::post('post/{id}',[PostController::class,'store'])->name('WYSIWYG.store');
Route::get('show/{id}',[PostController::class,'show'])->name('WYSIWYG.show');
Route::get('edit/{id}/{course_id}/{item_id}',[PostController::class,'edit'])->name('WYSIWYG.edit');
Route::post('update/{id}/{course_id}/{item_id}',[PostController::class,'update'])->name('WYSIWYG.update');
//quiz
Route::get('/add-quiz/{current_id}',[QuizController::class,'addQuiz'])->name('add.quiz');
Route::post('/store-quiz',[QuizController::class,'storeQuiz'])->name('store.quiz');
Route::get('/edit-quiz/{id}/{course_id}/{item_id}',[QuizController::class,'editQuiz'])->name('edit.quiz');
Route::post('/update-quiz/{id}/{course_id}/{item_id}',[QuizController::class,'updateQuiz'])->name('update.quiz');
Route::get('/quiz-list/{current_id}',[QuizController::class,'index'])->name('list.quiz');
Route::get('/add-question/{id}',[QuestionController::class,'addQuestion'])->name('add.question');
Route::get('/edit-question/{id}/{quiz_id}',[QuestionController::class,'editQuestion'])->name('edit.question');
Route::post('/store-question',[QuestionController::class,'storeQuestion'])->name('store.question');
Route::post('/update-question/{id}/{quiz_id}',[QuestionController::class,'updateQuestion'])->name('update.question');
Route::delete('/delete-question/{id}',[QuestionController::class,'deleteQuestion'])->name('delete.question');
Route::get('/results/{current_id}',[ResultController::class,'index'])->name('results');
//chatBot

Route::get('/chatBot',[ChatController::class,'index'])->name('chat.index');
Route::post('/Startchating',[ChatController::class,'startChat'])->name('chat.startChat');
Route::post('/chatBotConversation',[ChatController::class,'chat'])->name('chat.chat');
    });

});