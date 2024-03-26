@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">All Questions <span class="badge bg-primary">{{ count($data) }}</span></h1>

    <div class="card">

        <div class="card-header">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Add New</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable no-footer dtr-inline" id="datatables-reponsive">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>
                                    {{ $i->question }}
                                </td>

                                <td>
                                    {{ $i->category->name }}
                                </td>

                                <td>
                                    <a href="{{ route('teacher.questions.edit', $i->id) }}" class="btn btn-info">
                                        <i class="align-middle" data-feather="edit"></i>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('teacher.questions.create') }}" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Question Type</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select name="type" class="form-select">
                            <option value="mcq">MCQ Question</option>
                            <option value="fitb">Fill in the Blanks</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
