@extends('layouts.master')
@section('css')

@section('title')
    {{ trans('teacher_courses.Result List') }}

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<style>
    .hrContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh; /* This will make the container take up the full height of the viewport */
}

hr {
    border-top: 15px dotted rgb(199, 214, 199);
    border-right: none;
    border-bottom: none;
    border-left: none;
    width: 20%;
}

    .card-body {
    position: relative;
}
.overlay {
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 11;
    top: 0;
    left: 0;
    background-color: rgb(242, 242, 242);
    overflow: auto;
    transition: 0.5s;
    display: none; /* Add this to initially hide the overlay */
    
}

.overlay-content {
    position: relative;
    top: 25%;
    width: 100%;
    text-align: left;
    margin-top: 30px;
    overflow: auto;
    font-size: 1.25rem;
}

.overlay .closebtn {
    position: absolute;
    top: 20px;
    right: 45px;
    font-size: 2rem;
}
.block {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    margin: auto;
    width: 50%;
}

.popup-container {
    position: relative;
}

.popup-content {
    display: none;
    position: absolute;
    bottom: calc(100% + 20px); /* Position it below the button */
    left: 30%; /* Center horizontally */
    transform: translateX(-50%); /* Adjust horizontally to center */
    top: 100%; /* position it below the button */
    bottom: 20px;
    /* right: 20px; */
    width: 300px;
    max-height: 400px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 9;
    height: 400px;
}

#popup-btn {
    background-color: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
}

#popup-btn i {
    font-size: 48px;
    color: #198754; /* Customize the color as needed */
}

.chat-message {
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
}

.chat-message.me {
    background-color: #198754;
    color: #fff;
}

.avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.user-message {
    background-color: #198754;
    color: #fff;
    border-radius: 10px;
    padding: 10px;
}

.chat-gpt-message {
    background-color: #f0f0f0;
    align-self: flex-end;
}

.messages {
    padding: 10px;
    max-height: 300px;
    overflow-y: auto;
}

.message .text {
    padding: 8px 12px;
    border-radius: 10px;
    max-width: 80%;
}

.chat-messages {
    padding: 10px;
}

.chat-input {
    flex: 1;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 8px 12px;
    border: none;
    background-color: #f0f0f0;
    border-radius: 20px;
    cursor: pointer;
    resize: vertical;
    width: 100%;
    min-height: 20px; /* adjust this as needed */
    max-height: 60px; /* adjust this as needed */
    overflow-y: auto;
}

#chatForm input[type="text"] {
    flex: 1;
}
.spital{
    font-size: 8px;
}
@media screen and (max-width:430px){
    th,td{
    font-size: 10px;
}
.spital{
    font-size: 5px;
}
}
</style>
@section('PageTitle')
    {{ trans('teacher_courses.Result List') }}

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
@php
if(isset($shows->last()->gpt_result))
    $lastResult=$shows->last()->gpt_result;

    else {
        $lastResult="NO";
    }
  
    
@endphp
<div class="row">
    @foreach ($shows as $show)
    <div id="myOverlay_{{ $show->id }}" class="overlay">
        <!-- The Close Button -->
            <a href="javascript:void(0)" class="closebtn" onclick="closeOverlay({{ $show->id }})">×</a>
            <!-- The Content -->
           <div class="overlay-content">
            <p>{{ $show->gpt_result }}</p>
            </div>
        </div>
    @endforeach
    <div class="col-md-12 mb-30">
        
        <div class="card card-statistics h-100">
            
            <div class="card-body">
               
                <div class="text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('teacher_courses.Title') }}</th>
                                <th scope="col">{{ trans('teacher_courses.Quiz Score') }}
                                </th>
                                @if (auth('teacher')->check())
                                    <th scope="col"> {{ trans('teacher_courses.User Score') }}
                                    </th>
                                    <th scope="col">{{ trans('teacher_courses.User Name') }}
                                    </th>
                                @else
                                    <th scope="col"> {{ trans('teacher_courses.My Score') }}</th>
                                @endif
                                <th scope="col"> {{ trans('teacher_courses.Date') }}</th>
                                @if (auth('student')->check())
                                <th scope="col">{{ trans('teacher_courses.AI Suggestions result') }} </th>
                                        @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($shows as $show)
                                <tr>
                                    <th scope="row">{{ $sl++ }}</th>
                                    <td>{{ $show->title }}</td>
                                    <td>{{ $show->quiz_score }}</td>
                                    <td>{{ $show->achieved_score }}</td>
                                        <!-- The Button -->
                                        
                                    @if (auth('teacher')->check())
                                        <td>{{ $show->getTranslation('student_name', app()->getLocale()) }}</td>
                                    @endif
                                    <td>{{ $show->created_at }}</td>
                                    @if (auth('student')->check())
                                    <td>
                                        <button id="myButton_{{ $show->id }}"  class="spital btn btn-success"  onclick="openOverlay({{ $show->id }})">{{ trans('teacher_courses.Show Result') }}</button>
                                        </td>
                                        @endif
                                    <!-- The Overlay -->
                        <!-- The Overlay -->
                                    

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (auth('student')->check())
                    <form style="display:inline" action="{{ route('Courses.editable', $current_id) }}" method="GET"
                        class="mt-3">
                        <button type="submit" class="button-cancel">{{ trans('teacher_courses.Return') }}</button>
                    </form>
                @elseif(auth('teacher')->check())
                    <form style="display:inline" action="{{ route('lesson.editable', $current_id) }}" method="GET"
                        class="mt-3">
                        <button type="submit" class="button-cancel">{{ trans('teacher_courses.Return') }}</button>
                    </form>
                @endif


            </div>
            @if (auth('student')->check())
            <div class="hrContainer"><hr></div>
            @endif
            @if (auth('student')->check())
            <div class="block">
                <div class="popup-container">
                    <!-- Realistic robot icon -->
                    <button id="popup-btn"><i class="fas fa-robot"></i></button>
                    <!-- Chat content -->
                    <br>
                    <div class="popup-content" style="margin-top:2px ">
                        <div class="messages">
                            <div class="message chat-gpt-message" style="background-color: #f0f0f0; border-radius: 10px; padding: 10px;">
                                {{$lastResult}}</div>
                        </div>
                        <form id="chatForm">
                            <input type="hidden" name="lastMessage" id="lastMessage" value="{{$lastResult}}">
                            <input type="text" id="message" name="message" class="chat-input"
                                placeholder="Enter message..." autocomplete="off">
                                <div id="spinner" style="display: none;">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            <button type="submit" class="chat-input">Send</button>
                        </form>
                    </div>

                </div>
            </div>
            @endif
        </div>

    </div>

</div>
<!-- row closed -->
@endsection
@section('js')

<script>
     
    $(document).ready(function() {
        // Show the content initially
        $('#popup-btn').click(function() {
    $('.popup-content').slideToggle(300, function() {
        // Adjust margin-bottom of .block based on popup visibility
        if ($('.popup-content').is(':visible')) {
            $('.block').css('margin-bottom', '400px');
        } else {
            $('.block').css('margin-bottom', '10px');
        }
    });
});

        var finalResult = $('#lastMessage').val().trim();
        // Start chat session for the student immediately upon page load
        $.ajax({
            url: "/StartStudentchat",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                "finalResult": finalResult

            }
        }).done(function(res) {
            console.log(res);
            // You can handle the response if needed
        }).fail(function(xhr, status, error) {
            console.error(xhr.responseText);
            // Handle error here
        });

        $('#chatForm').submit(function(event) {
            event.preventDefault();

            var message = $('#message').val().trim();

            if (message === '') {
                return;
            }

            $('#message').prop('disabled', true);
            $('button[type="submit"]').prop('disabled', true);
            $('#spinner').show(); // Show the spinner

            $.ajax({
                url: "/chat",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    "message": message
                }
            }).done(function(res) {
                console.log(res);
                let parser = new DOMParser();
    let dom = parser.parseFromString(message, 'text/html');

    message=dom.body.textContent || "";
   
                // Append user message to the chat window
                $('.messages').append(
                    '<div class="message user-message" style="background-color: #59a200; border-radius: 10px; padding: 10px;">' +
                    message + '</div>');
                    parser = new DOMParser();
     dom = parser.parseFromString(res.message, 'text/html');

     res.message=dom.body.textContent || "";
                // Append GPT response message to the chat window
                $('.messages').append(
                    '<div class="message chat-gpt-message" style="background-color: #f0f0f0; border-radius: 10px; padding: 10px;">' +
                    res.message + '</div>');

                // Cleanup

                $('#message').val('');
                $('#message').prop('disabled', false);
                $('button[type="submit"]').prop('disabled', false);
                $('#spinner').hide(); // Hide the spinner
            }).fail(function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error here
                alert("Failed to send message. Please try again later.");
                $('#message').prop('disabled', false);
                $('button[type="submit"]').prop('disabled', false);
                $('#spinner').hide(); // Hide the spinner
            });
        });
    });
    function openOverlay(id) {
    document.getElementById("myOverlay_" + id).style.display = "block";
}

function closeOverlay(id) {
    document.getElementById("myOverlay_" + id).style.display = "none";
}

document.addEventListener('click', function(event) {
    var isClickInside = document.querySelector('.popup-container').contains(event.target);
    if (!isClickInside) {
        closeOverlay();
    }
});

    
</script>


@endsection
