@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Edit Question</h1>


    <form action="{{ route('teacher.questions.update',$question->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 mb-4">
                <label class="form-label">Question</label>
                <input type="text" name="question" class="form-control" placeholder="write your question"
                    value="{{ $question->question }}" required>
                @error('question')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            @if ($question->type == 'mcq')
                <div class="col-md-6 mb-4">
                    <label class="form-label">Option 1</label>
                    <input type="text" name="opt_1" class="form-control" value="{{ $question->opt_1 }}" required>
                    @error('opt_1')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Option 2</label>
                    <input type="text" name="opt_2" class="form-control" value="{{ $question->opt_2 }}" required>
                    @error('opt_2')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Option 3</label>
                    <input type="text" name="opt_3" class="form-control" value="{{ $question->opt_3 }}">
                    @error('opt_3')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Option 4</label>
                    <input type="text" name="opt_4" class="form-control" value="{{ $question->opt_4 }}">
                    @error('opt_4')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correct Option</label>
                    <select name="answer" class="form-select" required>
                        <option value="1" {{ $question->correct_answer == '1' ? 'selected' : '' }}>Option 1</option>
                        <option value="2" {{ $question->correct_answer == '2' ? 'selected' : '' }}>Option 2</option>
                        <option value="3" {{ $question->correct_answer == '3' ? 'selected' : '' }}>Option 3</option>
                        <option value="4" {{ $question->correct_answer == '4' ? 'selected' : '' }}>Option 4</option>
                    </select>
                </div>
            @else
                <div class="col-md-6">
                    <label class="form-label">Answer</label>
                    <input type="text" name="answer" class="form-control" placeholder="write the correct answer"
                        value="{{ $question->correct_answer }}">
                </div>
            @endif

            <div class="col-md-6 mb-4">
                <label class="form-label">Question Category</label>
                <select name="category" class="form-select" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>


        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('teacher.questions.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
