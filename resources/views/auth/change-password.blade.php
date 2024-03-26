@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Profile</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('changePassword') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" min="8" required>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Retype Password</label>
                    <input type="password" name="password_confirmation" class="form-control" min="8" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection