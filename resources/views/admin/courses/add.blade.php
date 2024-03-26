@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Add New Course</h1>


    <form action="{{ route('admin.courses.store') }}" method="post">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Course Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection