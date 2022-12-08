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
Route::get('/teacher/home', [App\Http\Controllers\HomeController::class, 'teacherIndex'])->name('teacher/home');

Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin/home');
Route::get('/admin/teacher', [App\Http\Controllers\AdminViewController::class, 'manage_teacher'])->name('admin/teacher');
Route::get('/admin/sections', [App\Http\Controllers\AdminViewController::class, 'manage_sections'])->name('admin/sections');


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



