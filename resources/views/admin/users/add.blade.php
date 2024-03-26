@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Add New User</h1>


    <form action="{{ route('admin.users.store') }}" method="post">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student" selected>Student</option>
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection