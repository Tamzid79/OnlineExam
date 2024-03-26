@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Edit Category</h1>


    <form action="{{ route('teacher.categories.update', $category->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{$category->name}}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('teacher.categories.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection