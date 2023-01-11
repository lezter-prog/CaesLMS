<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UtilDB;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('token/get', [LoginController::class, 'createToken']);


// Route::resource('profile', ProfileController::class);
Route::middleware('auth:sanctum')->controller(ProfileController::class)->group(function(){
    Route::get('profile', 'getProfile');
    Route::patch('profile/update', 'update');
    Route::post('profile/upload', 'fileupload');
});

Route::middleware('auth:sanctum')->controller(SectionController::class)->group(function(){
    Route::get('section/get', 'getSections');
    Route::get('section/get/select2', 'getAllSection2');
    Route::get('section/subjects/get', 'getSubjectSection');
    Route::post('section/create', 'createSection');
    Route::patch('section/{sectionCode}/update', 'updateSection');
});

Route::middleware('auth:sanctum')->controller(StudentController::class)->group(function(){
    Route::get('student/get', 'getAllStudentAccount');
    Route::get('student/get/{sectionCode}', 'getStudentsBySection');
    Route::post('student/create', 'createStudentAccount');
    Route::post('student/import', 'importStudents');
    Route::patch('student/{idNumber}/update', 'updateStudent');
});

Route::middleware('auth:sanctum')->controller(TeacherController::class)->group(function(){
    Route::get('teacher/get', 'getAllTeachers');
    Route::get('teacher/get/select2', 'getAllTeachers2');
    Route::post('teacher/create', 'createTeacher');
    Route::patch('teacher/{teacherId}/update', 'updateTeacher');
});

Route::middleware('auth:sanctum')->controller(SubjectController::class)->group(function(){
    Route::get('subjects/get/all', 'getAllSubjects');
    Route::get('subjects/get', 'getSubjectByGradeCode');
    Route::get('subjects/get/select2', 'getAllSubjects2');
    Route::post('subject/create', 'createSubject');
    Route::patch('subject/{sucbjectCode}/update', 'updateSubject');
});


Route::middleware('auth:sanctum')->controller(UtilDB::class)->group(function(){
    Route::get('quarters/get/all', 'getAllQuarters');
    Route::patch('quarter/update/{quarterCode}','updateQuarter');
    Route::post('lesson/create','addLesson');
    Route::get('lesson/get/all','getAllLesson');
    Route::get('lesson/get/{sectionCode}','getLessonBySectionCode');
    Route::post('announcement/create','addAnnouncement');
    Route::get('announcement/get/all', 'getAllAnnouncement');
    Route::get('announcement/get/student', 'getStudentAnnouncement');
    Route::patch('announcement/update', 'updateAnnouncement');
    Route::get('grades/get/all', 'getAllGrades');
    Route::patch('user/update/password', 'updatePassword');

    
});


