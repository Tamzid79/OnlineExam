@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="h3 mb-3">{{$exam->name}} Submissions <span class="badge bg-primary">{{ count($exam->submissions) }}</span></h1>
        </div>
        <div class="col-6">
            <a href="{{route('teacher.exams.index')}}" class="btn btn-dark float-end">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Time</th>
                            <th>Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exam->submissions()->orderBy('marks', 'desc')->get() as $i)
                            <tr>
                                <td>
                                    {{ $i->user->name }}
                                </td>

                                <td>
                                    {{ $i->user->email }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($i->created_at)->format('d-m-Y h:i A') }}
                                </td>

                                <td>
                                    {{ $i->marks }}
                                </td>

                                <td>
                                    <a href="{{route('teacher.students.show.details', ['sId'=>$i->user_id, 'examId'=>$i->exam_id])}}" class="btn btn-info"><i data-feather="eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                sort: false
            });
        });
    </script>
@endpush