@extends('layouts.master')
@section('css')
    <style>
        /* Custom CSS styles for the quiz page */
        .quiz-container {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .question {
            margin-bottom: 20px;
        }

        .question label {
            font-weight: bold;
        }

        .options {
            margin-bottom: 10px;
        }

        .options select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            margin-top: 20px;
            text-align: center;
        }
        #pre-loader {
    display: none;
}

    </style>
@endsection

@section('title')
{{trans('student_courses.Its a Quiz Page')}}
@stop

@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('student_courses.Quiz Title')}}: {{ $quiz->title }}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- quiz container -->
<div id="pre-loader">
    <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
</div>
@php
    $item = DB::table('items')
        ->where('quiz_id', $quiz->id)
        ->first();
    $section = DB::table('sections')
        ->where('id', $item->section_id)
        ->first();
    $current_id = $section->course_id;
@endphp
<div class="quiz-container">
    <h3>{{trans('student_courses.Exam Time')}}
       : {{ $quiz->duration }} {{trans('student_courses.Minutes')}}
    </h3>
    <h4>{{trans('student_courses.Timer')}}
        : <span id="timer_style"><span id="minutes">00</span>:<span id="seconds">00</span></span></h4>

    <form id="quizForm" method="post" action="{{ route('store.answer', ['current_id' => $current_id]) }}">

        @csrf
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" readonly required>
        <input id="start_time" type="hidden" name="start_time" value="{{ $start_time }}" readonly required>

        @php $i=1; @endphp
        @foreach ($questions as $question)
            <div class="question">
                <h5> <label>{{trans('student_courses.Question')}} {{ $i++ }}: {{ $question->question }}</label></h5>
                <div class="options">
                    <select name="answer[{{ $question->id }}]" class="form-control" required>
                        <option value="" selected disabled>{{trans('student_courses.Select an answer')}}
                        </option>
                        <option value="option_a">{{ $question->option_a }}</option>
                        <option value="option_b">{{ $question->option_b }}</option>
                        <option value="option_c">{{ $question->option_c }}</option>
                        <option value="option_d">{{ $question->option_d }}</option>
                    </select>
                </div>
            </div>
        @endforeach

        <div class="submit-btn">
            <button type="submit" class="btn btn-primary">{{trans('student_courses.Submit')}}
            </button>
        </div>
    </form>
</div>
<!-- end quiz container -->
@endsection

@section('js')
<script>
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = 0;
    var timerInterval;

    // Function to start the timer
    function startTimer() {
        timerInterval = setInterval(setTime, 1000);
    }

    // Function to update timer display
    function setTime() {
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }

    // Function to pad single digit with leading zero
    function pad(val) {
        var valString = val + "";
        return valString.length < 2 ? "0" + valString : valString;
    }

    // Function to stop the timer and display time's up message
    function timeUp() {
        clearInterval(timerInterval);
        document.getElementById('timer_style').innerHTML = "Time's Up!";
        document.getElementById('timer_style').style.color = 'red';
    }

    // Set the timer duration
    setTimeout(timeUp, {{ $quiz->duration * 60 * 1000 }});
    startTimer();

    document.getElementById('quizForm').addEventListener('submit', function() {
    document.querySelector('.quiz-container').style.display = 'none';
    document.getElementById('pre-loader').style.display = 'block';

});


</script>
@endsection
