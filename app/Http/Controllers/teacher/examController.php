<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Exam;
use App\Models\User;
use App\Notifications\ExamNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class examController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Exam::where('user_id', Auth::id())->with('course')->latest()->get();
        return view('teacher.exams.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::latest()->get();
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('teacher.exams.add', compact('courses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'instructions' => 'required',
            'time' => 'required',
            'exam_date' => 'required',
            'point' => 'required',
            'negative' => 'required',
            'course' => 'required',
        ]);

        $questions = $request->questions ?? [];

        $exam = Exam::create([
            'name' => $request->name,
            'instructions' => $request->instructions,
            'time' => $request->time,
            'exam_date' => $request->exam_date,
            'point' => $request->point,
            'negative' => $request->negative,
            'course_id' => $request->course,
            'user_id' => Auth::id(),
            'total' => count($questions)*($request->point)
        ]);

        $exam->questions()->attach($questions);

        $students = User::where('role', 'student')->get();
        Notification::send($students, new ExamNotification($exam));

        notyf('New Exam has been added', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return view('teacher.exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        if($exam->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }
        $courses = Course::latest()->get();
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('teacher.exams.edit', compact('exam', 'courses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        if($exam->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required',
            'instructions' => 'required',
            'time' => 'required',
            'exam_date' => 'required',
            'point' => 'required',
            'negative' => 'required',
            'course' => 'required',
        ]);

        $questions = $request->questions ?? [];
        $exam->questions()->sync($questions);

        $exam->update([
            'name' => $request->name,
            'instructions' => $request->instructions,
            'time' => $request->time,
            'exam_date' => $request->exam_date,
            'point' => $request->point,
            'negative' => $request->negative,
            'course_id' => $request->course,
            'total' => count($exam->questions)*($request->point)
        ]);

        notyf('Exam has been updated', 'success');
        return redirect()->route('teacher.exams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        if($exam->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }
        $exam->delete();
        notyf('Exam has been deleted', 'error');
        return redirect()->back();
    }
}
