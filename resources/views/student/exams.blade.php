@extends('layouts.app')

@push('css')
    <style>
        #swal2-html-container{
            white-space: pre;
        }
    </style>
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="h3 mb-3">{{ $course->name }}</span></h1>
        </div>
        <div class="col-6">
            <a href="/" class="btn btn-dark float-end">Back</a>
        </div>
    </div>

    <div class="row">
        @foreach ($course->exams as $exam)
            <div class="card">

                <div class="card-body">
                    <h3>{{ $exam->name }}</h3>
                    <div class="row">

                        <div class="col-md-4 col-6">
                            <div class="card mb-2">
                                <a class="btn"> <i class="align-middle" data-feather="clock"></i> {{ $exam->time }}
                                    minutes</a>
                            </div>
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="card mb-2">
                                <a class="btn"> <i class="align-middle" data-feather="check-circle"></i> Total Marks:
                                    {{ $exam->total }}</a>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card mb-2">
                                <a class="btn text-danger"> <i class="align-middle" data-feather="minus-circle"></i>
                                    Negative Mark:
                                    {{ $exam->negative }}</a>
                            </div>
                        </div>
                        @if ($exam->exam_date > \Carbon\Carbon::now())
                        <a href="javascript:void(0)">
                            <div class="btn btn-info col-12">The examination is scheduled for {{\Carbon\Carbon::parse($exam->exam_date)->format('d M Y')}}</div>
                        </a>
                        @elseif(count($exam->submissions))
                        <a href="{{route('exam.result', $exam->id)}}">
                            <div class="btn btn-primary col-12">View Result</div>
                        </a>
                        @else
                        <a href="javascript:void(0)" onclick="showConfirmation({{ $exam->id }}, ('{{ json_encode($exam->instructions) }}'))">
                            <div class="btn btn-primary col-12">Start Exam</div>
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach

    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showConfirmation(id, text) {
        Swal.fire({
            title: "Are you ready?",
            text: text.slice(1, -1),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Start Now!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = window.location.origin + '/exam/' + id
            }
        });
    }
</script>
@endpush
