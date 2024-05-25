@extends('layouts.master')
@section('css')

@section('title')
EduAI ChatBot
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<style>
    /* Your existing styles here... */

    /* Add this for the spinner */
    #spinner {
        display: inline-block;
    }

    #spinner .fa-spinner {
        margin-left: 10px;
    }
    .input-group {
    display: flex;
    width: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
    white-space: pre-wrap; 
}

.input-group .input-group-append {
    display: inline-block;
}
.user-message{
    color: #fff;
}
.message{
    font-size: 15px !important;

}
</style>
@section('PageTitle')
   EduAI ChatBot
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
@php
    $instructor = auth()->user()->Name;
    
@endphp
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <br><br>
                
                <br><div class="block">
                   <input type="hidden" id="instructor" name="instructor" value="{{$instructor}}">
                    <div class="messages">
                        
                    </div>
                    <form id="chatForm">
                        <div class="input-group">
                            <textarea id="message" name="message" class="form-control" 
                                placeholder="Enter message..." autocomplete="off" rows="3" style="resize: none;"></textarea>
                            <div id="spinner" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" class=" btn bg-success text-light fw-bold">Send</button>                            </div>
                        </div><br>
                      
                       
                        
                    </form>
                </div><br>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    var instructor = $('#instructor').val().trim();
$(document).ready(function() {
    
    $.ajax({
        url: "/Startchating", 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
                "instructor": instructor

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
            url: "{{ route('chat.chat') }}", // Using named route
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
            $('.messages').append('<div class="message user-message" style="background-color: #59a200; border-radius: 10px; padding: 10px;">' + message + '</div>');
            parser = new DOMParser();
     dom = parser.parseFromString(res.message, 'text/html');

     res.message=dom.body.textContent || "";
            // Append GPT response message to the chat window
            $('.messages').append('<div class="message chat-gpt-message" style="background-color: #f0f0f0; border-radius: 10px; padding: 10px;">' + res.message + '</div>');

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
</script>
@endsection