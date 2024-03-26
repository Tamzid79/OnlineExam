<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Question;
use App\Models\Submission;
use App\Models\User;
use App\Notifications\ExamNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class dashboardController extends Controller
{
    public function dashboard(){
        $courses = Course::latest()->get();
        return view('welcome', compact('courses'));
    }

    public function adminDashboard(){
        $courses = Course::count();
        $questions = Question::count();
        $students = User::where('role', 'student')->count();
        $teachers = User::where('role', 'teacher')->count();

        return view('admin.dashboard', compact('courses', 'questions', 'students', 'teachers'));
    }
    
    public function teacherDashboard(){
        $courses = Course::count();
        $questions = Question::where('user_id', Auth::id())->count();
        $students = User::where('role', 'student')->count();

        return view('teacher.dashboard', compact('courses', 'questions', 'students',));
    }

    public function singleCourse($id){
        $course = Course::with(['exams', 'exams.submissions' => function($query) {
            $query->select('id', 'user_id', 'exam_id')->where('user_id', Auth::id());
        }])->findorfail($id);
        return view('student.exams', compact('course'));
    }

    public function myResults(){
        $submissions = Submission::with(['exam'=> function($query){
            $query->select('id', 'name', 'course_id');
        }, 'exam.course' => function($query){
            $query->select('id', 'name');
        }])->where('user_id', Auth::id())->latest()->get();

        return view('student.my-results', ['data' => $submissions]); 
    }

    public function showChangePasswordForm(){
        return view('auth.change-password');
    }
    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        Auth::user()->update(['password' => bcrypt($request->password)]);
        notyf('Password has been changed', 'success');
        return redirect()->back();
    }
}
