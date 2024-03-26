@extends('layouts.app')

@push('css')
    <style>
        #sidebar {
            display: none;
        }

        .timer-container {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 10px;
            z-index: 100;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body mt-3">

            <div class="row mt-3" style="font-family: 'Times New Roman', Times, serif">
                <div class="col-12 text-center mb-3">
                    <h3> <strong>{{ $exam->name }}</strong></h3>
                    <h4>Course: {{ $exam->course->name }}</h4>
                    <p>Total-{{ $exam->total }} marks; Time: {{ $exam->time }} Minutes</p>
                    <p class="text-danger">[Note: Each incorrect answer will result in a deduction of {{ $exam->negative }}
                        marks]</p>
                </div>
            </div>
            <hr>

            <div class="timer-container bg-danger text-white">
                <i data-feather="clock"></i> <span id="updateTimer">{{ gmdate('H:i:s', $time * 60) }}</span>
            </div>

            <div class="row mt-3 mb-3">

                <form action="" method="POST" id="examForm">
                    @foreach ($exam->questions as $index => $question)
                        @if ($question->type == 'mcq')
                            <div class="mb-2">
                                <strong class="text-primary">Q.No {{ $index + 1 }} : </strong> {{ $question->question }}
                            </div>
                            <div class="mb-2">
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" value="1"
                                        name="q_{{ $question->id }}">
                                    <span class="form-check-label">
                                        {{ $question->opt_1 }}
                                    </span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" value="2"
                                        name="q_{{ $question->id }}">
                                    <span class="form-check-label">
                                        {{ $question->opt_2 }}
                                    </span>
                                </label>
                                @if ($question->opt_3)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" value="3"
                                            name="q_{{ $question->id }}">
                                        <span class="form-check-label">
                                            {{ $question->opt_3 }}
                                        </span>
                                    </label>
                                @endif
                                @if ($question->opt_4)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" value="4"
                                            name="q_{{ $question->id }}">
                                        <span class="form-check-label">
                                            {{ $question->opt_4 }}
                                        </span>
                                    </label>
                                @endif
                            </div>
                            <hr>
                        @else
                            <div class="mb-2">
                                <strong class="text-primary">Q.No {{ $index + 1 }} : </strong>
                                {{ $question->question }}
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control" style="width: 203px"
                                    placeholder="write your answer" autocomplete="off" id="q_{{ $question->id }}">
                            </div>
                            <hr>
                        @endif
                    @endforeach
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-lg btn-primary">Submit Exam</button>
                    </div>
                </form>

            </div>

        </div><!--card body end-->
    </div><!--card  end-->
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const questions = {!! json_encode($exam->questions, JSON_UNESCAPED_UNICODE) !!};

            let examTime = parseFloat("{{ $time }}") * 60
            let interval = setInterval(() => {
                examTime--;
                if (examTime == 0 || examTime < 0) {
                    clearInterval(interval)
                    submit()
                } else {
                    $("#updateTimer").html(formatTime(examTime))
                }
            }, 1000);

            function submit() {
                let answers = {};
                $.each(questions, function(i, e) {
                    if(e.type == 'mcq'){
                        answers[`q_${e.id}`] = $(`input[name=q_${e.id}]:checked`).val() ?? ''
                    }else{
                        answers[`q_${e.id}`] = $(`#q_${e.id}`).val() ?? ''
                    }
                });
                Swal.fire({
                    icon: "warning",
                    title: "Do not exit while the exam is being submitted.",
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "{{route('exam.submit')}}",
                    data: `id={{ $exam->id }}&data=${JSON.stringify(answers)}&_token={{ csrf_token() }}`,
                    success: function(response) {
                        Swal.fire({
                            title: "Submitted!",
                            text: "Your exam has been submitted.",
                            icon: "success",
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = response;
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Something Wen't Wrong!",
                            text: `${JSON.parse(xhr.responseText).message}`,
                            icon: "error",
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                        });
                    }
                });
            }

            $('#examForm').on('submit', function(e) {
                e.preventDefault();
                submit()
            });

            function formatTime(seconds) {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const remainingSeconds = Math.round(seconds % 60); // Round to handle precision issues

                const formattedTime =
                    `${padWithZero(hours)}:${padWithZero(minutes)}:${padWithZero(remainingSeconds)}`;

                return formattedTime;
            }

            function padWithZero(number) {
                return number < 10 ? `0${number}` : number;
            }
        })
    </script>
@endpush
