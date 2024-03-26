<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('role', 'student')->latest()->get();
        return view('teacher.students.index', compact('data'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $submissions = Submission::with('exam', 'exam.course')->where('user_id', $id)->latest()->get();
        return view('teacher.students.show', compact('submissions'));
    }

    public function showDetails($sId, $examId)
    {
        $submission = Submission::where([['user_id', $sId], ['exam_id', $examId]])->with('exam', 'exam.course', 'exam.questions')->first();
        if (!$submission) {
            return redirect()->back();
        }
        $answers = json_decode($submission->answers, true);
        return view('student.result', ['exam' => $submission->exam, 'answers' => $answers, 'submission' => $submission]);
    }
}
