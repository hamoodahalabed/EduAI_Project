@extends('layouts.master')
@section('css')

@section('title')

{{trans('teacher_courses.Edit Question for the Quiz')}}: {{$quiz->title}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Edit Question for the Quiz')}}: {{$quiz->title}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">


                <div class="text-center">
                    <div>
                        <form method="post" action="{{route('update.question', ['id' => $question->id,'quiz_id'=>$quiz->id])}}">
                            @csrf
                            <div class="form-group">
                                <input type="text" value="{{ $question->question }}" name="question" required class="form-control">
                            </div>
                            <input type="hidden" name="quiz_id" value="{{$quiz}}" readonly required>
                            <div class="form-group">
                                <input type="text" value="{{ $question->option_a }}" name="option_a" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $question->option_b }}" name="option_b" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $question->option_c }}" name="option_c" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $question->option_d }}" name="option_d" required class="form-control">
                            </div>
                            <div class="form-group">
                                <select class="form-control" style="padding-top: 5px" name="correct_option" required>
                                    <option value="option_a" {{ $question->correct_option === 'option_a' ? 'selected' : '' }}>A</option>
                                    <option value="option_b" {{ $question->correct_option === 'option_b' ? 'selected' : '' }}>B</option>
                                    <option value="option_c" {{ $question->correct_option === 'option_c' ? 'selected' : '' }}>C</option>
                                    <option value="option_d" {{ $question->correct_option === 'option_d' ? 'selected' : '' }}>D</option>
                                </select>
                            </div>
                            
                            <div class="text-left">
                                <button class="btn btn-success" type="submit">{{trans('teacher_courses.Edit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('teacher_courses.Question')}}
                            </th>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">{{trans('teacher_courses.Correct')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl=1;
                        @endphp
                       @foreach($questions as $ques)
                           <tr>
                               <th scope="row">{{$sl++}}</th>
                               <td>{{$ques->question}}</td>
                               <td>{{$ques->option_a}}</td>
                               <td>{{$ques->option_b}}</td>
                               <td>{{$ques->option_c}}</td>
                               <td>{{$ques->option_d}}</td>
                               <td>{{$ques->correct_option}}</td>
                           </tr>
                   @endforeach
                   
                        </tbody>
                    </table>
                </div>            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

<script>
    function correctAnswer(){
        let a = document.getElementsByName('option_a')
        alert('a');
    }
        </script>
@endsection







