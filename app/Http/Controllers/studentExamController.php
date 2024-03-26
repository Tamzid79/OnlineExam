<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Submission;
use App\Models\Temp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentExamController extends Controller
{
    public function liveExam($id){
        $user_id = Auth::id();

        $exam = Exam::with('questions', 'course', 'temps')->withCount(['submissions'=>function($query) use($user_id){
            $query->where('user_id', $user_id);
        }])->findorfail($id);

        if($exam->exam_date > Carbon::now()){
            notyf("The examination is scheduled for ".Carbon::parse($exam->exam_date)->format('d M Y'), 'error');
            return redirect()->back();
        }

        if($exam->submissions_count){
            return redirect()->route('exam.result', ['id' => $exam->id]);
        }

        $temp = $exam->temps->where('user_id', $user_id)->first();
        $time = $exam->time;
        if ($temp) {
            $allowed_duration = $time * 60;
            $time_difference = abs(Carbon::now()->diffInSeconds($temp->created_at));
            if ($allowed_duration <= $time_difference) {
                Submission::create([
                    'exam_id' => $exam->id,
                    'user_id' => $user_id,
                    'marks' => 0,
                    'total_marks' => $exam->total,
                    'total' => count($exam->questions),
                    'correct' => 0,
                    'wrong' => 0,
                    'answers' => json_encode([]),
                ]);
                $exam->temps()->where('user_id', $user_id)->delete();

                notyf('Times Up! Exam has auto submitted!', 'error');
                return redirect()->route('exam.result', ['id' => $exam->id]);
            } else {
                $time = ($allowed_duration - $time_difference) / 60;
            }
        } else {
            Temp::create([
                'exam_id' => $exam->id,
                'user_id' => $user_id
            ]);
        }
        return view('student.exam', compact('exam', 'time'));
    }

    public function submit(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $user_id = Auth::id();
        $exam = Exam::with('questions', 'temps')->withCount(['submissions'=>function($query) use($user_id){
            $query->where('user_id', $user_id);
        }])->findOrFail($request->id);
        
        if ($exam->submissions_count) {
            return redirect()->route('exam.result', ['id' => $exam->id]);
        }
        $answers = json_decode($request->data, true);

        $correct = 0;
        $wrong = 0;
        $skip = 0;

        foreach ($exam->questions as $q) {
            if ($answers['q_' . $q->id] == null) {
                $skip++;
            } elseif ($answers['q_' . $q->id] == $q->correct_answer) {
                $correct++;
            } elseif ($answers['q_' . $q->id] != $q->correct_answer) {
                $wrong++;
            }
        }

        Submission::create([
            'exam_id' => $exam->id,
            'user_id' => $user_id,
            'marks' => ($correct - ($wrong * $exam->negative)),
            'total_marks' => $exam->total,
            'total' => $correct + $wrong + $skip,
            'correct' => $correct,
            'wrong' => $wrong,
            'answers' => json_encode($answers),
        ]);

        $exam->temps()->where('user_id', $user_id)->delete();

        return response()->json(route('exam.result', ['id' => $exam->id]));
    }

    public function examResult($id){
        $submission = Submission::where([['user_id', Auth::id()], ['exam_id', $id]])->with('exam', 'exam.course', 'exam.questions')->first();
        if(!$submission){
            return redirect('/');
        }
        $answers = json_decode($submission->answers, true);
        return view('student.result', ['exam' => $submission->exam, 'answers' => $answers, 'submission' => $submission]);
    }

    public function meritList($id){
        $exam = Exam::with('submissions', 'submissions.user')->findOrFail($id);
        return view('student.merit', ['exam' => $exam, 'submissions' => $exam->submissions()->orderBy('marks', 'desc')->get()]);
    }
}
