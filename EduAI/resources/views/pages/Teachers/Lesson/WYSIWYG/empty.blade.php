@extends('layouts.master')
@section('css')
{{-- <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@section('title')
Laravel 10 Summernote
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
   WYSIWYG
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<div id="my-section">
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="container p-4 ">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h1 class="">Laravel 10 Summernote Text Editor with Image Upload CRUD (create read update and delete)</h1>
                            </div> 
                            <form action="{{route('WYSIWYG.store')}}" method="post">
                                @csrf
                                <label for="">Title:</label>
                                <input type="text" class="form-control" name="title">
                                <label for="">Description:</label>
                                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $('#description').summernote({
        placeholder: 'description...',
        tabsize:2,
        height:300
    });
</script>
@endsection
