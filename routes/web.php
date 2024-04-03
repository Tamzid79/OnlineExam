<?php

use App\Http\Controllers\admin\categoryController as AdminCategoryController;
use App\Http\Controllers\admin\courseController;
use App\Http\Controllers\admin\examController as AdminExamController;
use App\Http\Controllers\admin\questionController as AdminQuestionController;
use App\Http\Controllers\admin\studentController as AdminStudentController;
use App\Http\Controllers\admin\userController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\studentExamController;
use App\Http\Controllers\teacher\categoryController;
use App\Http\Controllers\teacher\examController;
use App\Http\Controllers\teacher\questionController;
use App\Http\Controllers\teacher\studentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth', 'admin']],function(){
    Route::get('dashboard', [dashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('courses', courseController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('questions', AdminQuestionController::class);
    Route::resource('exams', AdminExamController::class);
    
    Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('students/{id}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('students/{sId}/details/{examId}', [AdminStudentController::class, 'showDetails'])->name('students.show.details');
    
    Route::resource('users', userController::class);
});

Route::group(['prefix' => 'teacher', 'as' => 'teacher.','middleware' => ['auth', 'teacher']],function(){
    Route::get('dashboard', [dashboardController::class, 'teacherDashboard'])->name('dashboard');
    Route::resource('categories', categoryController::class);
    Route::resource('questions', questionController::class);
    Route::resource('exams', examController::class);

    Route::get('students', [studentController::class, 'index'])->name('students.index');
    Route::get('students/{id}', [studentController::class, 'show'])->name('students.show');
    Route::get('students/{sId}/details/{examId}', [studentController::class, 'showDetails'])->name('students.show.details');
});

Route::group(['middleware' => ['auth', 'student']],function(){

    Route::get('/', [dashboardController::class, 'dashboard']);
    Route::get('course/{id}', [dashboardController::class, 'singleCourse'])->name('singleCourse');
    Route::get('my-results', [dashboardController::class, 'myResults'])->name('myResults');

    Route::get('exam/{id}', [studentExamController::class, 'liveExam'])->name('liveExam');
    Route::post('exam/submit', [studentExamController::class, 'submit'])->name('exam.submit');
    Route::get('exam/{id}/result', [studentExamController::class, 'examResult'])->name('exam.result');
    Route::get('exam/{id}/merit-list', [studentExamController::class, 'meritList'])->name('exam.meritList');
});

Route::get('change-password', [dashboardController::class, 'showChangePasswordForm'])->middleware('auth')->name('changePassword');
Route::post('change-password', [dashboardController::class, 'updatePassword'])->middleware('auth')->name('changePassword');
Route::get('dashboard', function(){
    $role = Auth::user()->role;
    if($role == 'admin'){
        return redirect()->route('admin.dashboard');
    }
    elseif($role == 'teacher'){
        return redirect()->route('teacher.dashboard');
    }
    return redirect('/');
})->middleware('auth')->name('dashboard');

Auth::routes();