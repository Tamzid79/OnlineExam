@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="h3 mb-3">{{$exam->name}} Merit List</h1>
        </div>
        <div class="col-6">
            <a href="{{route('myResults')}}" class="btn btn-dark float-end">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submissions as $key => $i)
                            <tr>
                                <td>{{$key+1}}</td>

                                <td>
                                    {{ $i->user->name }}
                                </td>

                                <td>
                                    {{ $i->user->email }}
                                </td>

                                <td>
                                    {{ $i->marks }}
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