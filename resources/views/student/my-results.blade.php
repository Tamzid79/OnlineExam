@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="h3 mb-3">My Results</span></h1>
        </div>
        <div class="col-6">
            <a href="/" class="btn btn-dark float-end">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                        <thead>
                            <tr>
                                <th>Exam</th>
                                <th>Course</th>
                                <th>Submission Date</th>
                                <th>Obtained Marks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>
                                        <a href="{{route('exam.result', $i->exam->id)}}">
                                            {{ $i->exam->name }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{route('singleCourse', $i->exam->course->id)}}">
                                            {{ $i->exam->course->name }}
                                        </a>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($i->created_at)->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        <a href="{{route('exam.result', $i->exam->id)}}">
                                            {{ $i->marks }}/{{ $i->total_marks }}
                                        </a>
                                    </td>

                                    <td>
                                        <a class="btn btn-info" href="{{route('exam.meritList',$i->exam->id)}}">View Merit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable();
        });
    </script>
@endpush