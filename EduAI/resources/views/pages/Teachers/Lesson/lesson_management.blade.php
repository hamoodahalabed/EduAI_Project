@extends('layouts.master')

@section('css')
<style>
  .dropdown {
    position: relative;
    display: block; /* Change display to block */
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

.dropdown-toggle:hover {
    background-color: #e9ecef; /* Hover background color */
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

  .buttonLe {
    background: #198754;
    padding: 0.5em 1em; /* Adjust padding */
    font-size: 1rem;
    letter-spacing: 1px;
    border: 0;
    color: #ffffff;
    font-weight: 500;
    display: inline-block;
    border-radius: 0.3em; /* Adjust border-radius */
    text-align: center;
    border: 2px solid #198754;
    cursor: pointer;
    transition: all 0.5s ease;
}

/* Add media queries for responsiveness */
@media screen and (max-width: 768px) {
    .buttonLe {
        font-size: 0.9rem; /* Adjust font size for smaller screens */
        padding: 0.4em 0.8em; /* Adjust padding for smaller screens */
    }
}

@media screen and (max-width: 576px) {
    .buttonLe {
        font-size: 0.8rem; /* Further adjust font size for even smaller screens */
        padding: 0.3em 0.6em; /* Further adjust padding for even smaller screens */
    }
}

.myFile {
    color: blue;
    transition: all 0.3s ease;
}

.myFile:hover {
    color: blue;
    text-decoration: underline;
}

.myFile:active {
    color: purple;
    font-style: italic;
    text-decoration: underline;
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
                <button class="buttonLe" data-toggle="modal" data-target="#addSectionModal">{{trans('teacher_courses.Add New Section')}}
                    </button>

            <button class="buttonLe" data-toggle="modal" data-target="#EditSectionsPositionModal" aria-pressed="true"><i  class="fa fa-edit"></i>{{trans('teacher_courses.Edit Sections Position')}}
                </button>
            <span class="dropdown show buttonLe" style="padding: 0" role="button" >
                <a class="buttonLe" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('teacher_courses.Operations')}}
                </a>
                <span class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('Item.create',$current_id) }}" ><i style="color:green" class="fa fa-edit"></i>&nbsp;{{trans('teacher_courses.Add new book')}}
                      </a>
                    <a class="dropdown-item"  href="{{ route('Item.create_youtube_url',$current_id) }}" ><i style="color:green" class="fa fa-edit"></i>&nbsp; {{trans('teacher_courses.Add Youtube Link')}}
                        </a>
                    <a class="dropdown-item"  href="{{route('WYSIWYG.create',$current_id)}}"><i style="color:green" class="fa fa-edit"></i>&nbsp;{{trans('teacher_courses.Add new post')}}
                        </a>


                </span>
            </span>
            <span class="dropdown show buttonLe" style="padding: 0" >
                <a class="buttonLe" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('teacher_courses.Quiz Operations')}}
                </a>
                <span class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{route('add.quiz',$current_id)}}" ><i style="color:green" class="fa fa-edit"></i>&nbsp; {{trans('teacher_courses.Add Quiz')}}
                        </a>
                    <a class="dropdown-item"  href="{{route('list.quiz',$current_id)}}" ><i style="color:green" class="fa fa-edit"></i>&nbsp;{{trans('teacher_courses.Quiz List')}}
                        </a>
                    <a class="dropdown-item"  href="{{route('results',$current_id)}}"><i style="color:green" class="fa fa-edit"></i>&nbsp;{{trans('teacher_courses.Student Results')}}
                        </a>


                </span>
            </span>

                <br> <br>
                <!-- Modal -->

                <form action="{{ route('save-order') }}" method="POST">
                    @csrf
                    @foreach ($sections->sortBy('position') as $section )
                    @if($section->course_id==$current_id)
                    <div class="row draggable-section" data-section-id="{{ $section->id }}">
                        <div class="col-md-12" style="width: 100%; position: relative; display: block">
                            <!-- Move the .dropdown-toggle button outside the column container -->
                            <div style="display: flex; align-items: center;">
                                <button type="button" class="dropdown-toggle" onclick="toggleDropdown('{{ $section->id }}')" style="width: 100%; text-align: left; position: relative;">
                                    <span style="display: inline-block;">
                                        {{ $section->name }}
                                    </span>

                                    <span class="dropdown show" style="position: absolute; right: 50px; top: 5px;">
                                        <a class="buttonLe" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{trans('teacher_courses.Operations')}}

                                        </a>
                                        <span class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" onclick="toggleEditModalSection('{{ $section->id }}')" ><i style="color:green" class="fa fa-edit"></i>&nbsp;  {{trans('teacher_courses.Edit Section')}}
                                               </a>
                                            <a class="dropdown-item"  onclick="toggleDeleteModalSection('{{ $section->id }}')" data-toggle="modal"><i style="color: red" class="fa fa-trash"></i>&nbsp;{{trans('teacher_courses.Delete Section')}}
                                                </a>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="dropdown">
                        <div class="dropdown-content" id="dropdownContent{{ $section->id }}">
                            <div class="sortable">
                                @foreach ($items->sortBy('position') as $item)
                                @if($section->id===$item->section_id)
                                <div class="align-items-start justify-content-center p-3" data-id="{{ $item->id }}" style="background-color: #fff; border: 5px solid #eef5f9; display: block; text-align: center; width: 100%;">
                                        @php
                                            $filePath = public_path('attachments/') . 'Items/' . $item->file_name;
                                            $mimeType = mime_content_type($filePath);
                                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                            $fileContent = file_get_contents(public_path('attachments/Items/'.$item->file_name));
                                            $first60Chars = substr($fileContent, 0, 60);
                                            $expectedString = '$2y$10$icrfILR/E1R9cV0AGrYw.OgJm6mylyyI8sS6jaTXn896e75CCP/Fq';
                                            $matchesExpected = ($first60Chars === $expectedString && substr($item->file_name, 10)==="Youtube_Video.txt");
                                            $after60Chars = substr($fileContent, 60);
                                        @endphp
                                        @if($item->wysiwyg_id===-1 && $item->quiz_id===-1)
                                            @if (strpos($mimeType, 'video') !== false)
                                            <b style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}</b>
                                                <video controls width="300" style="display: inline-block;">
                                                    <source src="{{ asset('attachments/Items/' . $item->file_name) }}" type="{{ $mimeType }}">
                                                    Your browser does not support the video tag.
                                                </video>

                                                @elseif (strpos($mimeType, 'audio') !== false)
                                                <div style="text-align: center;">
                                                    <b style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}</b>
                                                    <br><br>
                                                    <audio id="myAudio" controls style="width: 300px; margin: auto;">
                                                        <source src="{{ asset('attachments/Items/' . $item->file_name) }}" type="{{ $mimeType }}">
                                                        Your browser does not support the audio tag.
                                                    </audio>
                                                </div>

                                            @elseif (strpos($mimeType, 'image') !== false)
                                            <b style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}</b>
                                                <img src="{{ asset('attachments/Items/'. $item->file_name) }}" alt="{{ $item->name }}" width="300" style="display: inline-block;">
                                            @elseif (strpos($mimeType, 'application/pdf') !== false)
                                            <div style="text-align: left;">
                                                <a href="{{ asset('attachments/Items/' . $item->file_name) }}" target="_blank"><i class="fas fa-file-pdf" style="color: #ff7a7a"></i> <span class="myFile">{{ $item->name }}</span>
                                                  </a>
                                                </div>
                                            @else
                                                @if($matchesExpected==true)
                                                <b style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}</b>
                                                    <iframe class="embed-responsive-item" width="640" height="360" src="{{ $after60Chars }}" title="{{ $item->name }}" allowfullscreen style="max-width: 100%;"></iframe>
                                                @else
                                                <div style="text-align: left;">
                                                    <a href="{{ route('downloadAttachment', $item->file_name) }}" target="_blank"><i class="fas fa-file" style="color: #4ae09a"></i> <span class="myFile">{{ $item->name }}</span></a>
                                                </div>
                                                @endif
                                                @endif
                                                <div style="margin-top: 10px;">
                                                    @if($matchesExpected!=true)
                                                        <a href="{{ route('downloadAttachment', $item->file_name) }}" title="{{trans('teacher_courses.Download')}}" class="btn btn-warning btn-sm " role="button" aria-pressed="true"><i class="fas fa-download"></i>  {{trans('teacher_courses.Download')}}
                                                            </a>
                                                        <a href="{{ route('Item.edit',['id' => $item->id, 'current_id' => $current_id]) }}" class="btn btn-info btn-sm " role="button" aria-pressed="true"><i class="fa fa-edit"></i>{{trans('teacher_courses.Edit2')}}
                                                            </a>
                                                        @endif
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="toggleDeleteModal({{ $item->id }})" title="{{trans('teacher_courses.Delete')}}"><i class="fa fa-trash"></i>{{trans('teacher_courses.Delete')}}
                                                            </button>
                                                    </div>
                                                @elseif($item->wysiwyg_id !=-1)
                                                    @php
                                                        $post = \App\Models\Post::findOrFail($item->wysiwyg_id);
                                                    @endphp
                                                   <div style="text-align: left;">
                                                    {!! $post->description !!}
                                                </div>

                                                    <a href="{{ route('WYSIWYG.edit', ['id' => $item->wysiwyg_id, 'course_id' => $current_id, 'item_id'=>$item->id]) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                        <i class="fa fa-edit"></i>{{trans('teacher_courses.Edit2')}}

                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="toggleDeleteModal({{ $item->id }})" title="{{trans('teacher_courses.Delete')}}"><i class="fa fa-trash"></i>{{trans('teacher_courses.Delete')}}</button>
                                                    @else
                                                    @php
                                                    $quiz = \App\Models\Quiz::findOrFail($item->quiz_id);
                                                    @endphp
                                                    <table class="table">
                                                        <tr>
                                                            <td>{{$quiz->title}}</td>
                                                            <td>{{$quiz->from_time}}</td>
                                                            <td>{{$quiz->to_time}}</td>
                                                            <td>{{$quiz->duration}}{{trans('teacher_courses.minutes')}}</td>
                                                            <td><a href="/add-question/{{$quiz->id}}" target="_blank">{{trans('teacher_courses.Questions Management')}}</a></td>
                                                            <td>  <a href="{{ route('edit.quiz', ['id' => $item->quiz_id, 'course_id' => $current_id, 'item_id'=>$item->id]) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                                <i class="fa fa-edit"></i>{{trans('teacher_courses.Edit2')}}
                                                            </a></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm" onclick="toggleDeleteModal({{ $item->id }})" title="{{trans('teacher_courses.Delete')}}"><i class="fa fa-trash"></i>{{trans('teacher_courses.Delete')}}</button></td>
                                                        </tr>
                                                    </table>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="dropdownMargin{{ $section->id }}"></div>
                        @endif
                        @endforeach

                        <input type="hidden" name="tag_order" id="tag_order">
                        <br>
                        <br><br><br><br><br><br><br><br>
                        <button type="submit" class="buttonLe">{{trans('teacher_courses.Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($items as $item)
        @isset($item)
            @include('pages.Teachers.Lesson.destroy')
        @endisset
    @endforeach

    @include('pages.Teachers.Lesson.Section.create')

    @foreach ($sections as $section)
        @isset($section)
            @include('pages.Teachers.Lesson.Section.destroy')
        @endisset
    @endforeach

    @foreach ($sections as $section)
        @isset($section)
            @include('pages.Teachers.Lesson.Section.edit')
        @endisset
    @endforeach
    @include('pages.Teachers.Lesson.Section.edit_Postions')

    @endsection

    @section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        // Event delegation for dynamically generated elements
        $(document).on('sortable', '.draggable-section', function() {
            $(this).sortable({
                handle: ".dropdown-toggle", // Set the handle to the dropdown-toggle button
                update: function(event, ui) {
                    updateSectionOrder();
                }
            });
        });


        // Initialize sortable for existing and dynamically added draggable-section elements
        $(".draggable-section").trigger('sortable');
    });

    function updateSectionOrder() {
        var sectionOrder = [];
        $(".draggable-section").each(function() {
            sectionOrder.push($(this).data('section-id'));
        });
        // Here you can update the order of sections as needed
        console.log("Section Order:", sectionOrder);
    }

    function toggleDeleteModal(itemId) {
        $('#delete_item_' + itemId).modal('toggle');
    }

    function toggleDeleteModalSection(sectionId) {
        $('#delete_section_' + sectionId).modal('toggle');
    }

    function toggleEditModalSection(sectionId) {
        $('#EditSectionModal_' + sectionId).modal('toggle');
    }

    $(function() {
        $(".sortable").sortable({
            update: function(event, ui) {
                updateTagOrder();
            }
        }).disableSelection();
    });

    function updateTagOrder() {
        var tagOrder = [];
        $(".sortable").each(function() {
            $(this).find('> div').each(function() {
                tagOrder.push($(this).attr('data-id'));
            });
        });
        $("#tag_order").val(tagOrder.join(","));
    }

    function toggleDropdown(sectionId) {
        var dropdownContent = document.getElementById("dropdownContent" + sectionId);
        var dropdownMargin = document.getElementById("dropdownMargin" + sectionId);

        if (dropdownContent.style.display === "none") {
            dropdownContent.style.display = "block";
            dropdownMargin.style.marginBottom = dropdownContent.clientHeight + "px";
        } else {
            dropdownContent.style.display = "none";
            dropdownMargin.style.marginBottom = "0";
        }
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                    var sectionId = openDropdown.id.replace('dropdownContent', '');
                    document.getElementById("dropdownMargin" + sectionId).style.marginBottom = "0";
                }
            }
        }
    }
</script>
@endsection
