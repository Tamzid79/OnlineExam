@extends('layouts.app')

@push('css')
    <style>
        .btn:active{
            border: none;
        }
    </style>
@endpush

@section('content')
    <h1 class="h3 mb-3">Dashboard</span></h1>

    <div class="row">
        @foreach ($courses as $course)
        <div class="col-md-4 col-6">
            <a href="{{route('singleCourse',$course->id)}}" class="btn mb-0 d-grid w-100">
                <div class="card mb-2">
                    <div class="card-body">
                        <h3>{{$course->name}}</h3>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
@endsection