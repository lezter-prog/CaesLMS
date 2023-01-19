<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/student/home', [App\Http\Controllers\HomeController::class, 'studentIndex'])->name('student/home');
Route::get('/student/handled/subject', [App\Http\Controllers\StudentViewController::class, 'subject'])->name('student/handled/subject');


// Assesment
Route::get('/assesment/multiple', [App\Http\Controllers\AssesmentViewController::class, 'assesmentMultiple'])->name('assesment/multiple');



Route::get('/teacher/home', [App\Http\Controllers\HomeController::class, 'teacherIndex'])->name('teacher/home');
Route::get('/teacher/handled/section', [App\Http\Controllers\TeacherViewController::class, 'section'])->name('teacher/handled/section');
Route::get('/teacher/announcement', [App\Http\Controllers\TeacherViewController::class, 'manage_announcement'])->name('teacher/announcement');


Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin/home');
Route::get('/admin/teacher', [App\Http\Controllers\AdminViewController::class, 'manage_teacher'])->name('admin/teacher');
Route::get('/admin/sections', [App\Http\Controllers\AdminViewController::class, 'manage_sections'])->name('admin/sections');
Route::get('/admin/students', [App\Http\Controllers\AdminViewController::class, 'manage_students'])->name('admin/students');
Route::get('/admin/subjects', [App\Http\Controllers\AdminViewController::class, 'manage_subjects'])->name('admin/subjects');
Route::get('/admin/quarter', [App\Http\Controllers\AdminViewController::class, 'manage_quarter'])->name('admin/quarter');
Route::get('/admin/announcement', [App\Http\Controllers\AdminViewController::class, 'manage_announcement'])->name('admin/announcement');
Route::get('/admin/handled/sections', [App\Http\Controllers\AdminViewController::class, 'manage_handled_section'])->name('admin/handled/sections');
Route::get('/admin/icons', [App\Http\Controllers\AdminViewController::class, 'manage_icons'])->name('admin/icons');


Route::get('/admin/grades', [App\Http\Controllers\AdminViewController::class, 'manage_grades'])->name('admin/grades');
Route::get('/auth/change-password', [App\Http\Controllers\Auth\PasswordChangeController::class, 'changePassword'])->name('auth/change-password');


Route::get('/home', function () {
    $ROLE =Auth::user()->role;
    if($ROLE == "R1"){
        return redirect('/student/home');
    }else if($ROLE == "R2"){
        return redirect('/teacher/home');
    }else{
        return redirect('/admin/home');
    }
});



