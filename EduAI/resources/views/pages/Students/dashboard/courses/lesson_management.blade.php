@extends('layouts.master')

@section('css')
    <style>
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
                        <input type="hidden" id="course_id" name="course_id" value="{{ $current_id }}" />
                        @php
                            $studentId = auth()->user()->id;
                        @endphp



                        <br> <br>
                        <!-- Modal -->


                        @foreach ($sections->sortBy('position') as $section)

                            @if ($section->course_id == $current_id)
                                <div class="d-flex flex-row align-items-start justify-content-center p-3"
                                    style="
                    background-color: #fff;
                    border: 5px solid #eef5f9;
                    text-align: center;
                    ">
                                    <b class="d-flex align-items-center justify-content-center"
                                        style="
                        letter-spacing: 2.63px;
                        line-height: 32px;
                        max-width: 1118px;
                        ">
                                        {{ $section->name }}
                                    </b>
                                </div>



                                @foreach ($items->sortBy('position') as $item)
                                    @if ($section->id === $item->section_id)
                                        <div class="align-items-start p-3" data-id="{{ $item->id }}"
                                            style="background-color: #fff;  border-right: 5px solid #eef5f9;
                                    border-left: 5px solid #eef5f9; display: block; text-align: center; width: 100%;">
                                            @php
                                                $itemId = $item->id; // the ID of the item

                                                $record = DB::table('student_item')
                                                    ->where('student_id', $studentId)
                                                    ->where('item_id', $itemId)
                                                    ->first();
                                                $isChecked = $record ? $record->checked : 0;
                                            @endphp

                                            @php
                                                $filePath = public_path('attachments/') . 'Items/' . $item->file_name;
                                                $mimeType = mime_content_type($filePath);
                                                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                $fileContent = file_get_contents(
                                                    public_path('attachments/Items/' . $item->file_name),
                                                );
                                                $first60Chars = substr($fileContent, 0, 60);
                                                $expectedString =
                                                    '$2y$10$icrfILR/E1R9cV0AGrYw.OgJm6mylyyI8sS6jaTXn896e75CCP/Fq';
                                                $matchesExpected =
                                                    $first60Chars === $expectedString &&
                                                    substr($item->file_name, 10) === 'Youtube_Video.txt';
                                                $after60Chars = substr($fileContent, 60);
                                            @endphp
                                            @if ($item->wysiwyg_id === -1 && $item->quiz_id === -1)
                                                @if (strpos($mimeType, 'video') !== false)
                                                    @if ($fileExtension != 'm4a')
                                                        <b
                                                            style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}
                                                            <input type="checkbox" class="checkbox"
                                                                value="{{ $itemId }}"
                                                                @if ($isChecked) checked @endif>
                                                            <label for="checkbox"
                                                                @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label></b>
                                                        <div class="justify-content-center"
                                                            style="display: flex; justify-content: center;">
                                                            <div style="position: relative; width: 640px; height: 360px;">
                                                                <video id="video_{{ $item->id }}"
                                                                    class="embed-responsive-item" width="640"
                                                                    height="360"
                                                                    src="{{ asset('attachments/Items/' . $item->file_name) }}"
                                                                    title="{{ $item->name }}" controls
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></video>
                                                                <div id="videoOverlay_{{ $item->id }}"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                                                </div>


                                                            </div>
                                                        </div>
                                                    @else
                                                        <div style="text-align: left;">
                                                            <b
                                                                style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->name }}
                                                                <input type="checkbox" class="checkbox"
                                                                    value="{{ $itemId }}"
                                                                    @if ($isChecked) checked @endif>
                                                                <label for="checkbox"
                                                                    @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label></b>

                                                            <div style="position: relative;width: 300px;">
                                                                <audio id="audio_{{ $item->id }}" controls
                                                                    style="width: 300px; margin: auto;">
                                                                    <source
                                                                        src="{{ asset('attachments/Items/' . $item->file_name) }}"
                                                                        type="{{ $mimeType }}">
                                                                    Your browser does not support the audio tag.
                                                                </audio>
                                                                <div id="audioOverlay_{{ $item->id }}"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif
                                                @elseif (strpos($mimeType, 'audio') !== false)
                                                    <div style="text-align: left;">
                                                        <b
                                                            style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->name }}
                                                            <input type="checkbox" class="checkbox"
                                                                value="{{ $itemId }}"
                                                                @if ($isChecked) checked @endif>
                                                            <label for="checkbox"
                                                                @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label></b>

                                                        <div style="position: relative;width: 300px;">
                                                            <audio id="audio_{{ $item->id }}" controls
                                                                style="width: 300px; margin: auto;">
                                                                <source
                                                                    src="{{ asset('attachments/Items/' . $item->file_name) }}"
                                                                    type="{{ $mimeType }}">
                                                                Your browser does not support the audio tag.
                                                            </audio>
                                                            <div id="audioOverlay_{{ $item->id }}"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                                            </div>

                                                        </div>
                                                    </div>
                                                @elseif (strpos($mimeType, 'image') !== false)
                                                    <b
                                                        style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}
                                                        <input type="checkbox" class="checkbox" value="{{ $itemId }}"
                                                            @if ($isChecked) checked @endif>
                                                        <label for="checkbox"
                                                            @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label></b>
                                                    <div class="justify-content-center">
                                                        <img src="{{ asset('attachments/Items/' . $item->file_name) }}"
                                                            alt="{{ $item->name }}" width="300"
                                                            style="display: inline-block;" onclick="sendParameter(2);">
                                                    </div>
                                                @elseif (strpos($mimeType, 'application/pdf') !== false)
                                                    <div style="text-align: left;">
                                                        <input type="checkbox" class="checkbox" value="{{ $itemId }}"
                                                            @if ($isChecked) checked @endif>
                                                        <label for="checkbox"
                                                            @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label>
                                                            &nbsp;&nbsp;<a
                                                                href="{{ asset('attachments/Items/' . $item->file_name) }}"
                                                                target="_blank" onclick="sendParameter(4);"><i
                                                                    class="fas fa-file-pdf" style="color: #ff7a7a"></i>
                                                                <span class="myFile">{{ $item->name }}</span>
                                                            </a>
                                                    </div>
                                                @else
                                                    @if ($matchesExpected == true)
                                                        <b
                                                            style="width: 100%; position: relative; letter-spacing: 2.63px; line-height: 32px; display: block; margin-bottom: 10px;">{{ $item->name }}
                                                            <input type="checkbox" class="checkbox"
                                                                value="{{ $itemId }}"
                                                                @if ($isChecked) checked @endif>
                                                            <label for="checkbox"
                                                                @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label></b>
                                                        <div class="justify-content-center"
                                                            style="display: flex; justify-content: center;">
                                                            <div style="position: relative; width: 640px; height: 360px;">
                                                                <iframe id="iframe_{{ $item->id }}"
                                                                    class="embed-responsive-item" width="640"
                                                                    height="360" src="{{ $after60Chars }}"
                                                                    title="{{ $item->name }}" allowfullscreen
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                                                                <div id="iframeOverlay_{{ $item->id }}"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div style="text-align: left;">
                                                            <input type="checkbox" class="checkbox"
                                                                value="{{ $itemId }}"
                                                                @if ($isChecked) checked @endif>
                                                            <label for="checkbox"
                                                                @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif
                                                                </label>
                                                                &nbsp;&nbsp; <a
                                                                    href="{{ route('downloadBook', $item->file_name) }}"
                                                                    onclick="sendParameter(4);"><i class="fas fa-file"
                                                                        style="color: #4ae09a"></i> <span
                                                                        class="myFile">{{ $item->name }}</span></a>
                                                        </div>
                                                    @endif
                                                @endif
                                            @elseif($item->wysiwyg_id != -1)
                                                @php
                                                    $post = \App\Models\Post::findOrFail($item->wysiwyg_id);
                                                @endphp
                                                <div style="text-align: left;">
                                                    <input type="checkbox" class="checkbox" value="{{ $itemId }}"
                                                        @if ($isChecked) checked @endif>
                                                    <label for="checkbox"
                                                        @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label>
                                                        {!! $post->description !!}
                                                </div>
                                            @else
                                                @if ($item->quiz_id != -1)
                                                    @php
                                                        $quiz = \App\Models\Quiz::findOrFail($item->quiz_id);
                                                    @endphp
                                                    <table class="table">
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox"
                                                                    value="{{ $itemId }}"
                                                                    @if ($isChecked) checked @endif>
                                                                <label for="checkbox"
                                                                    @if ($isChecked) style="color:#22da31"><i class="fas fa-check"></i> @else style="color:#ff2a2a"><i class="fas fa-times"></i> @endif</label>
                                                            </td>
                                                            <td>{{ $quiz->title }}</td>
                                                            <td>{{ $quiz->from_time }}</td>
                                                            <td>{{ $quiz->to_time }}</td>
                                                            <td>{{ $quiz->duration }}
                                                                {{ trans('student_courses.minutes')}}
                                                            </td>
                                                           
                                                            <td>
                                                                @if (\DB::table('shows')->where('quiz_id', $quiz->id)->where('student_id', auth()->id())->exists())
                                                                <a
                                                                href="{{ route('shows', $quiz->id) }}">show result</a>
                                                                 @else
                                                                     No results!  
                                                                     @endif
                                                            </td>
                                                            <td><a
                                                                    href="/give-quiz/{{ $quiz->id }}"> {{trans('student_courses.Attempt quiz')}} : {{ $quiz->title }}</a>
                                                            </td>

                                                        </tr>
                                                    </table>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <div class="align-items-start p-3"
                            style="background-color: #fff;  border-top: 5px solid #eef5f9 ; display: block; text-align: center; width: 100%;">
                            <br></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('.checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var isChecked = this.checked ? 1 : 0; // Convert boolean to integer
                    var itemId = this.value;

                    // Get the label and icon elements
                    var label = this.nextElementSibling;
                    var icon = label.querySelector('i');

                    // Toggle the icon and color based on the checkbox state
                    if (isChecked) {
                        label.style.color = '#22da31';
                        icon.className = 'fas fa-check';
                    } else {
                        label.style.color = '#ff2a2a';
                        icon.className = 'fas fa-times';
                    }

                    // Create a new XMLHttpRequest for updating checkbox state
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '/updateCheckbox', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    // Handle the response
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log(xhr.responseText);
                        } else {
                            console.error(xhr.responseText);
                        }
                    };

                    // Send the AJAX request to update checkbox state
                    var data = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&item_id=' + encodeURIComponent(itemId) +
                        '&checked=' + encodeURIComponent(isChecked);
                    xhr.send(data);

                    // Create a new XMLHttpRequest for updating checked items counter
                    var counterXhr = new XMLHttpRequest();
                    counterXhr.open('POST', '/updateCheckedItemsCounter', true);
                    counterXhr.setRequestHeader('Content-Type',
                    'application/x-www-form-urlencoded');

                    // Handle the response
                    counterXhr.onload = function() {
                        if (counterXhr.status === 200) {
                            console.log(counterXhr.responseText);
                        } else {
                            console.error(counterXhr.responseText);
                        }
                    };

                    // Send the AJAX request to update checked items counter
                    var counterData = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&course_id=' + encodeURIComponent(document.getElementById('course_id')
                            .value);
                    counterXhr.send(counterData);
                });
            });
        });

        function sendParameter(type) {
            // Create a new XMLHttpRequest to update the click counter
            var clickCounterXhr = new XMLHttpRequest();
            clickCounterXhr.open('POST', '/updateClickCounter', true);
            clickCounterXhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Handle the response
            clickCounterXhr.onload = function() {
                if (clickCounterXhr.status === 200) {
                    console.log(clickCounterXhr.responseText);
                } else {
                    console.error(clickCounterXhr.responseText);
                }
            };

            // Determine the click type and send the AJAX request accordingly
            var clickData;
            switch (type) {
                case 1: // Video click
                    clickData = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&click_type=video';
                    break;
                case 2: // Image click
                    clickData = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&click_type=image';
                    break;
                case 3: // Audio click
                    clickData = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&click_type=audio';
                    break;
                case 4: // Document click
                    clickData = '_token=' + encodeURIComponent('{{ csrf_token() }}') +
                        '&click_type=document';
                    break;
                default:
                    console.error('Invalid click type');
                    return;
            }

            // Send the AJAX request to update the click counter
            clickCounterXhr.send(clickData);
        }

        //youtube video
        function clickVideo(itemId) {
            console.log(itemId);
            var myDiv = document.getElementById(itemId);
            myDiv.style.display = 'none';
            sendParameter(1);
        }

        //audio
        function clickAudio(itemId) {
            console.log(itemId);
            var myDiv = document.getElementById(itemId);
            myDiv.style.display = 'none';
            sendParameter(3);
        }

        function clickIframe(itemId) {
            console.log(itemId);
            var myIframe = document.getElementById('iframe_' + itemId);
            var myOverlay = document.getElementById('iframeOverlay_' + itemId);
            if (myIframe && myOverlay) {
                myOverlay.style.display = 'none';
                sendParameter(1);
            } else {
                console.log('Element not found: ', itemId);
            }
        }



        // Add event listener to each overlay div
        document.querySelectorAll('[id^="iframeOverlay_"]').forEach(function(overlay) {
            overlay.addEventListener('click', function() {
                clickIframe(this.id.replace('iframeOverlay_', ''));
            });
        });


        function clickVideo(itemId) {
            console.log(itemId);
            var myVideo = document.getElementById('video_' + itemId);
            var myOverlay = document.getElementById('videoOverlay_' + itemId);
            if (myVideo && myOverlay) {
                myOverlay.style.display = 'none';
                sendParameter(1);
            } else {
                console.log('Element not found: ', itemId);
            }
        }



        // Add event listener to each overlay div
        document.querySelectorAll('[id^="videoOverlay_"]').forEach(function(overlay) {
            overlay.addEventListener('click', function() {
                clickVideo(this.id.replace('videoOverlay_', ''));
            });
        });

        function clickAudio(itemId) {
            console.log(itemId);
            var myAudio = document.getElementById('audio_' + itemId);
            var myOverlay = document.getElementById('audioOverlay_' + itemId);
            if (myAudio && myOverlay) {
                myOverlay.style.display = 'none';
                sendParameter(3);
            } else {
                console.log('Element not found: ', itemId);
            }
        }



        // Add event listener to each overlay div
        document.querySelectorAll('[id^="audioOverlay_"]').forEach(function(overlay) {
            overlay.addEventListener('click', function() {
                clickAudio(this.id.replace('audioOverlay_', ''));
            });
        });
    </script>


@endsection
