@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">All Exams <span class="badge bg-primary">{{ count($data) }}</span></h1>

    <div class="card">

        <div class="card-header">
            <a href="{{route('teacher.exams.create')}}" class="btn btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Course</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>
                                    <div class="list-group">
                                        <li class="list-group-item"><strong>{{$i->name}}</strong></li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-6">
                                                    <i class="align-middle" data-feather="check-circle"></i> Total: {{$i->total}}
                                                </div>
                                                <div class="col-6">
                                                    <i class="align-middle" data-feather="clock"></i> Time: {{$i->time}} Minutes
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                </td>

                                <td>
                                    {{ $i->course->name }}
                                </td>
                                
                                <td>
                                    {{ \Carbon\Carbon::parse($i->exam_date)->format('d-m-Y') }}
                                </td>

                                <td>
                                    <a href="{{ route('teacher.exams.edit', $i->id) }}" class="btn btn-info">
                                        <i class="align-middle" data-feather="edit"></i>
                                    </a>
                                    <a href="{{ route('teacher.exams.show', $i->id) }}" class="btn btn-primary" title="All Submissions">
                                        <i class="align-middle" data-feather="list"></i>
                                    </a>
                                    <button class="btn btn-danger" onclick="deleteData({{ $i->id }})">
                                        <i class="align-middle" data-feather="trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="" method="post" id="delete-form">@csrf @method('DELETE')</form>
@endsection

@push('js')
    <script>
        const deleteForm = document.getElementById('delete-form');

        function deleteData(id) {
            let ask = confirm("Deleted file can't be restored");
            if (ask) {
                deleteForm.action = window.location.origin + window.location.pathname + '/' + id;
                deleteForm.submit();
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable();
        });
    </script>
@endpush
