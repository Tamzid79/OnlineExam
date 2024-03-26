@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Add New Category</h1>


    <form action="{{ route('teacher.categories.store') }}" method="post">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('teacher.categories.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection