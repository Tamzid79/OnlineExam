<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class questionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Question::query();
            if($request->cat && $request->cat != 'null'){
                $query->where('category_id', $request->cat);
            }
            if($request->input('search')){
                $keyword = $request->input('search');
                $query->where('question', 'like', "%$keyword%");
            }
            return response()->json($query->latest()->get());
        }
        
        $data = Question::with('category', 'user')->latest()->get();
        return view('admin.questions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->type;
        if(!$type){
            $type = 'mcq';
        }
        $categories = Category::latest()->get();
        return view('admin.questions.add', compact('categories', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'category' => 'required',
            'type' => 'required|in:mcq,fitb',
            'answer' => 'required'
        ]);

        $question = new Question();
        $question->question = $request->question;
        if($request->type == 'mcq'){
            $question->opt_1 = $request->opt_1;
            $question->opt_2 = $request->opt_2;
            $question->opt_3 = $request->opt_3;
            $question->opt_4 = $request->opt_4;
        }
        $question->correct_answer = $request->answer;
        $question->type = $request->type;
        $question->category_id = $request->category;
        $question->user_id = Auth::id();
        $question->save();

        notyf('New Question has been added', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $categories = Category::latest()->get();
        return view('admin.questions.edit', compact('categories', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|max:255',
            'category' => 'required',
            'answer' => 'required'
        ]);

        $question->question = $request->question;
        if($request->type == 'mcq'){
            $question->opt_1 = $request->opt_1;
            $question->opt_2 = $request->opt_2;
            $question->opt_3 = $request->opt_3;
            $question->opt_4 = $request->opt_4;
        }
        $question->correct_answer = $request->answer;
        $question->category_id = $request->category;
        $question->save();

        notyf('Question has been updated', 'success');
        return redirect()->route('admin.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        notyf('Question has been deleted', 'error');
        return redirect()->back();
    }
}
