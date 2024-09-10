@extends('layouts.l')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Chat Box -->
        <div class="col-md-8">
            <h5 class="text-center">Chat with Admin</h5>

            <!-- Chat box with scrollable messages -->
            <div class="chat-box border rounded p-3" style="height: 400px; overflow-y: scroll; background-color: #f9f9f9;">
                @foreach($messages as $message)
                    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }} mb-3" style="width: fit-content; max-width: 75%; padding: 10px; border-radius: 10px; {{ $message->sender_id == Auth::id() ? 'background-color: #007bff; color: white; margin-left: auto;' : 'background-color: #e9ecef; color: black; margin-right: auto;' }}">
                        <p class="mb-0">{{ $message->message }}</p>
                        @if($message->file_path)
                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" style="color: #fff; text-decoration: underline;">View Attachment</a>
                        @endif
                        <small class="d-block text-muted">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>

            <!-- Send Message Form (fixed at the bottom of chat box) -->
            <form action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="input-group">
                    <textarea name="message" placeholder="Type your message..." class="form-control" rows="1"></textarea>
                    <input type="file" name="file" class="form-control-file">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Chatbox message styling */
    .chat-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
    }

    .message.sent {
        background-color: #007bff;
        color: white;
        border-radius: 10px 10px 0 10px;
        margin-left: auto;
    }

    .message.received {
        background-color: #e9ecef;
        color: black;
        border-radius: 10px 10px 10px 0;
        margin-right: auto;
    }

    .chat-box .message {
        padding: 10px;
        margin-bottom: 10px;
        max-width: 75%;
        word-wrap: break-word;
    }

    .message .time {
        font-size: 0.8em;
        text-align: right;
        color: #999;
        margin-top: 5px;
    }

    /* Add responsiveness */
    @media (max-width: 768px) {
        .chat-box {
            height: 300px;
        }
    }
</style>

<script>
    // Scroll the chat box to the bottom on page load
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection

