@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Result Statistics</h5>
            </div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="chartjs-doughnut"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-xxl-5">
        <div class="w-100">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Obtained Marks</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="percent"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{$submission->marks}}/{{$submission->total_marks}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <a href="/" class="btn btn-dark float-end">Back</a>
                </div>
                <div class="col-12 list-group mb-4">
                    <h3 class="list-group-item fw-bold">{{$exam->name}}</h3>
                    <h4 class="list-group-item">Course: {{$exam->course->name}}</h4>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4">
                                <i class="align-middle" data-feather="check-circle"></i> Total: {{$exam->total}}
                            </div>
                            <div class="col-4">
                                <i class="align-middle" data-feather="minus-circle"></i> Negative: {{$exam->negative}}
                            </div>
                            <div class="col-4">
                                <i class="align-middle" data-feather="clock"></i> Time: {{$exam->time}} Minutes
                            </div>
                        </div>
                    </li>
                </div>
                
            </div>
        </div>
        
    </div>

</div>
    <div class="card">
        <div class="card-body mt-3">
            <div class="row mt-3 mb-3">
                    @foreach ($exam->questions as $index => $question)
                        @if ($question->type == 'mcq')
                            <div class="mb-2">
                                <strong class="text-primary">Q.No {{ $index + 1 }} : </strong> {{ $question->question }}
                            </div>
                            <div class="mb-2">
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" value="1" {{isset($answers['q_'.$question->id]) && $answers['q_'.$question->id] == '1' ? 'checked' : ''}} onclick="return false;">
                                    <span class="form-check-label">
                                        {{ $question->opt_1 }} {{$question->correct_answer == 1 ? '✔' : ''}}
                                        @if (isset($answers['q_'.$question->id]))
                                            @if ($answers['q_'.$question->id] == 1 && ($question->correct_answer != 1))
                                            ❌
                                            @endif
                                        @endif 
                                    </span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" value="2" {{isset($answers['q_'.$question->id]) && $answers['q_'.$question->id] == '2' ? 'checked' : ''}} onclick="return false;">
                                    <span class="form-check-label">
                                        {{ $question->opt_2 }} {{$question->correct_answer == 2 ? '✔' : ''}}
                                        @if (isset($answers['q_'.$question->id]))
                                            @if ($answers['q_'.$question->id] == 2 && ($question->correct_answer != 2))
                                            ❌
                                            @endif
                                        @endif
                                    </span>
                                </label>
                                @if ($question->opt_3)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" value="3" {{isset($answers['q_'.$question->id]) && $answers['q_'.$question->id] == '3' ? 'checked' : ''}} onclick="return false;">
                                        <span class="form-check-label">
                                            {{ $question->opt_3 }} {{$question->correct_answer == 3 ? '✔' : ''}}
                                            @if (isset($answers['q_'.$question->id]))
                                            @if ($answers['q_'.$question->id] == 3 && ($question->correct_answer != 3))
                                            ❌
                                            @endif
                                        @endif
                                        </span>
                                    </label>
                                @endif
                                @if ($question->opt_4)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" value="4" {{isset($answers['q_'.$question->id]) && $answers['q_'.$question->id] == '4' ? 'checked' : ''}} onclick="return false;">
                                        <span class="form-check-label">
                                            {{ $question->opt_4 }} {{$question->correct_answer == 4 ? '✔' : ''}}
                                            @if (isset($answers['q_'.$question->id]))
                                            @if ($answers['q_'.$question->id] == 4 && ($question->correct_answer != 4))
                                            ❌
                                            @endif
                                        @endif
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
                                <input type="text" style="width: 203px"
                                autocomplete="off" id="q_{{ $question->id }}" disabled value="{{isset($answers['q_'.$question->id]) ? $answers['q_'.$question->id] : ''}}">
                                @if (isset($answers['q_'.$question->id]))
                                    @if ($answers['q_'.$question->id] == $question->correct_answer)
                                    ✔
                                    @else
                                    ❌
                                    @endif
                                @endif
                                <br>
                                <span class="text-success"><strong>Right Answer</strong>: {{$question->correct_answer}}</span>
                            </div>
                            <hr>
                        @endif
                    @endforeach
                </form>

            </div>

        </div><!--card body end-->
    </div><!--card  end-->
@endsection

@push('js')
<script>
    let correct = parseInt('{{$submission->correct}}');
    let wrong = parseInt('{{$submission->wrong}}');
    let skip = parseInt('{{$submission->total}}') - correct - wrong;
    document.addEventListener("DOMContentLoaded", function() {
        // Doughnut chart
        new Chart(document.getElementById("chartjs-doughnut"), {
            type: "doughnut",
            data: {
                labels: ["Correct", "Wrong", "Skip"],
                datasets: [{
                    data: [correct, wrong, skip],
                    backgroundColor: [
                        window.theme.success,
                        window.theme.warning,
                        window.theme.primary,
                    ],
                    borderColor: "transparent"
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true
                }
            }
        });
    });
</script>
@endpush