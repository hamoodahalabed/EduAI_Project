@extends('layouts.master')
@section('css')

@section('title')
{{trans('teacher_courses.Add Question for the Quiz')}} : {{$quiz_list->title}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Add Question for the Quiz')}} : {{$quiz_list->title}}

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
                        <form method="post" action="{{route('store.question')}}">
                            @csrf
                            <div class="form-group">
                                <input type="text" placeholder="Question" name="question" required class="form-control">
                            </div>
                            <input type="hidden" name="quiz_id" value="{{$quiz_id}}" readonly required>
                            <div class="form-group">
                                <input type="text" placeholder="Option A" name="option_a" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Option B" name="option_b" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Option C" name="option_c" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Option D" name="option_d" required class="form-control">
                            </div>
                            <div class="form-group">
                                <select class="form-control" style="padding-top: 5px" name="correct_option" required>
                                    <option selected disabled value>-- {{trans('teacher_courses.Select Correct Option')}} --</option>
                                    <option value="option_a">A</option>
                                    <option value="option_b">B</option>
                                    <option value="option_c">C</option>
                                    <option value="option_d">D</option>
                                </select>
                            </div>
                            <div class="text-left">
                                <button class="button" type="submit">{{trans('teacher_courses.Add')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('teacher_courses.Question')}}</th>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">{{trans('teacher_courses.Correct')}}</th>
                            <th>{{trans('teacher_courses.Operations')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl=1;
                        @endphp
                        @foreach($questions as $question)
                            <tr>
                                <th scope="row">{{$sl++}}</th>
                                <td>{{$question->question}}</td>
                                <td>{{$question->option_a}}</td>
                                <td>{{$question->option_b}}</td>
                                <td>{{$question->option_c}}</td>
                                <td>{{$question->option_d}}</td>
                                <td>{{$question->correct_option}}</td>
                                <td>  <a href="{{ route('edit.question', ['id' =>$question->id, 'quiz_id' => $quiz_id]) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                    <i class="fa fa-edit"></i> {{trans('teacher_courses.Edit2')}}
                                </a></td>
                               
                                <td>
                                    <!-- Button to trigger the modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$question->id}}">
                                        <i class="fa fa-trash"></i> {{trans('teacher_courses.Delete')}}
                                    </button>
                                    @include('pages.Teachers.Lesson.Quiz.delete-modal', ['question' => $question])

                                    <!-- Include the delete modal -->
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>            </div>
        </div>
    </div>
</div>
<!-- row closed -->

<!-- Modal -->

@endsection
@section('js')

<script>
    function correctAnswer(){
        let a = document.getElementsByName('option_a')
        alert('a');
    }
    function confirmDelete(questionId) {
        $('#deleteModal'+questionId).modal('show');
    }

   
        </script>
@endsection







