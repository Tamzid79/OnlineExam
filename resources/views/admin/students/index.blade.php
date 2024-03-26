@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">All Students <span class="badge bg-primary">{{ count($data) }}</span></h1>

    <div class="card">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>
                                    {{ $i->name }}
                                </td>
                                <td>
                                    {{$i->email}}
                                </td>
                                <td>
                                    <a href="{{route('admin.students.show', $i->id)}}" class="btn btn-primary">
                                        View Results
                                    </a>
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
            $("#datatables-reponsive").DataTable();
        });
    </script>
@endpush