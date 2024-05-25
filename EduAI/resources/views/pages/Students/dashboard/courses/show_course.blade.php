@extends('layouts.master')

@section('css')
<style>
  .dropdown {
    position: relative;
    display: block; /* Change display to block */
  }

  .dropdown-toggle {
    text-align: left;
    background-color: #f1f1f1;
    border: none;
    padding: 12px 4px 4px 4px ;
  }

  .dropdown-toggle::after {
    content: '\25BC'; /* Unicode character for down arrow */
    float: right; /* Align the arrow to the right */
    margin-left: 5px; /* Add some spacing between the text and the arrow */
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
    width: 100%; /* Set width to 100% */
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }
  .dropdown-toggle {
    width: 100%;
    text-align: left;
    position: relative;
    background-color: #f8f9fa; /* Background color */
    border: 1px solid #ced4da; /* Border color */
    padding: 15px; /* Padding */
    cursor: pointer; /* Cursor style */
}



</style>
@endsection

@section('title')
{{$currentCourseTitle}}
@stop

@section('page-header')
<!-- breadcrumb -->
@endsection

@section('PageTitle')
{{$currentCourseTitle}}
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <br><br>
                    <!-- Modal -->
                    @foreach ($sections->sortBy('position') as $section)
                        @if ($section->course_id == $current_id)
                            <div class="row draggable-section" data-section-id="{{ $section->id }}">
                                <div class="col-md-12" style="width: 100%; position: relative; display: block">
                                    <!-- Move the .dropdown-toggle button outside the column container -->
                                    <div style="display: flex; align-items: center;">
                                        <button type="button" class="dropdown-toggle"  style="width: 100%; text-align: left; position: relative;">
                                            <span style="display: inline-block;">
                                                {{ $section->name }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

    @section('js')
@endsection
