<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function (){
    return redirect('/login');
});
Auth::routes([
    'register' => false,
]);
// Admin Part
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Amin routes
        Route::resource('admin', 'Admin\AdminController');
        Route::resource('roles', 'Admin\RoleController');
        Route::resource('userRoles', 'Admin\UserRoleController');
//        Route::resource('categories', 'Admin\CategoryController');
        Route::resource('users', 'Admin\UserController');
        Route::resource('settings', 'Admin\SettingController');
        Route::resource('colleges','Admin\CollegeController');
        Route::resource('lessons','Admin\LessonController');
        Route::resource('studentLessons','Admin\StudentLessonController');
        Route::resource('forms','Admin\FormController');
        Route::resource('answers','Admin\AnswerController');
    });
    Route::prefix('user')->name('user.')->group(function () {
        // User routes
        Route::resource('lessonForms','User\LessonFormController');
        Route::resource('educationForms','User\EducationFormController');
        Route::resource('allEducationForms','User\AllEducationController');
    });
    // Default
    Route::get('/home', 'HomeController@index')->name('home');
});



