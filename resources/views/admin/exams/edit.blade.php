@extends('layouts.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            /* White background with opacity */
            justify-content: center;
            align-items: center;
            z-index: 999;
            display: none;
            /* Ensures the loading container is on top of the page content */
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #0061ae;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #0061ae transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        a {
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <h1 class="h3 mb-3">Edit Exam</h1>


    <form action="{{ route('admin.exams.update', $exam->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 mb-4">
                <label class="form-label">Exam Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{$exam->name}}" required>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Instructions</label>
                <textarea name="instructions" rows="5" class="form-control" required>{{$exam->instructions}}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Exam Time <span class="text-danger">(Minute)</span></label>
                        <input type="number" name="time" class="form-control" min="1" value="{{$exam->time}}" required>
                        @error('time')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="col-md-6 mb-4">
                        <label class="form-label">Exam Date</label>
                        <input type="date" name="exam_date" class="form-control" value="{{$exam->exam_date}}" required>
                        @error('exam_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Point Per Question</label>
                        <input type="number" name="point" class="form-control" min="1" value="{{$exam->point}}" required>
                        @error('point')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Negative Mark</label>
                        <input type="number" step="any" name="negative" class="form-control" min="0"
                            value="{{$exam->negative}}" required>
                        @error('negative')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label class="form-label">Select Course</label>
                <select name="course" class="form-select" required>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{$exam->course_id == $course->id ? 'selected' : ''}}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-4">
                <br>
                <button type="button" class="btn btn-lg btn-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#addModal">Add Questions</button>
            </div>

            <div class="col-12 mb-4">
                <select name="questions[]" class="form-select selec2" id="questions" multiple>
                    @foreach ($exam->questions as $question)
                        <option value="{{$question->id}}" selected>{{$question->question}}</option>
                    @endforeach
                </select>
            </div>


        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.exams.index') }}" class="btn btn-dark">Back</a>
            <button type="submit" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="selectQuestionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="loading-container">
                    <div class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="modal-header d-block">
                    <div class="row">
                        <div class="col-4">
                            <select class="form-select" onchange="loadQuestions(this.value)">
                                <option value="">---</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-3">
                            <form action="" method="get" id="searchForm">
                                <input type="text" class="form-control" id="search" placeholder="search">
                            </form>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="row" id="previewQuestions">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let category = null;
        let data = null;
        $(document).ready(function() {
            $('#questions').select2();

            $('#category').on('change', function(e) {
                if (e.target.value) {
                    category = e.target.value;
                    loadQuestions();
                }
            });
        });

        function loadQuestions(id = null) {
            if (id) {
                category = id;
            }
            $('.loading-container').css('display', 'flex');
            $.ajax({
                type: "GET",
                header: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: `${window.location.origin}/admin/questions?cat=${category}&search=${$("#search").val()}`,
                success: function(response) {
                    console.log(response);
                    let html = ``;
                    response.forEach(e => {
                        if (e.type == 'mcq') {
                            html += `
                        <div class="col-md-6 shadow bg-body-tertiary rounded mb-3" id="question-${e.id}">
                            <div class="card border-1 border-primary">
                            <div class="card-header d-flex flex-wrap justify-content-between">
                                <div>${e.question}</div>
                                <div>
                                    <a href="javascript:void(0)" class="text-danger" onclick="addQuestion(${e.id})">Add</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>1. ${e.opt_1}</p>
                                <p>2. ${e.opt_2}</p>
                                ${e.opt_3 ? ('<p>3. '+e.opt_3+'</p>') : ''}
                                ${e.opt_4 ? ('<p>4. '+e.opt_4+'</p>') : ''}
                            </div>
                            </div>
                        </div>
                    `;
                        } else {
                            html += `
                        <div class="col-md-6 shadow bg-body-tertiary rounded mb-3" id="question-${e.id}">
                            <div class="card border-1 border-primary">

                            <div class="card-header d-flex flex-wrap justify-content-between">
                                <div>${e.question}</div>
                                <div>
                                    <a href="javascript:void(0)" class="text-danger" onclick="addQuestion(${e.id})">Add</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    `;
                        }
                    });
                    $("#previewQuestions").html(html);
                    data = response;
                    $('.loading-container').hide();
                }
            });
        }

        function addQuestion(id) {
            let question = data.find((e) => e.id == id);
            if (question) {
                $("#questions").append(`<option value="${id}" selected>${(question.question)}</option>`);
                $("#question-" + id).remove();
            }
        }

        $("#searchForm").on('submit', function(e) {
            e.preventDefault();
            loadQuestions();
        });
    </script>
@endpush