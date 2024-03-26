@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Edit Course</h1>


    <form action="{{ route('admin.courses.update', $course->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="form-label">Course Name</label>
            <input type="text" name="name" class="form-control" value="{{$course->name}}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection