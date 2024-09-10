@extends('layouts.l')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Chat Box -->
        <div class="col-md-8">
            <div class="card" style="background-color: #f8f9fa; border-radius: 10px; padding: 15px;">
                <!-- Chat Heading -->
                <div class="card-header text-center bg-primary text-white" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h5>Chat with Admin</h5>
                </div>

                <!-- Chat Box Area -->
                <div class="chat-box" style="height: 400px; overflow-y: auto; padding: 15px; background-color: #ffffff; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                    @foreach($messages as $message)
                        <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}" style="margin-bottom: 10px;">
                            <div class="p-2" style="background-color: {{ $message->sender_id == Auth::id() ? '#e9ecef' : '#cce5ff' }}; border-radius: 10px; max-width: 75%; margin-left: {{ $message->sender_id == Auth::id() ? 'auto' : '0' }};">
                                <p style="margin-bottom: 5px;">{{ $message->message }}</p>
                                @if($message->file_path)
                                    <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" style="color: #007bff;">View Attachment</a>
                                @endif
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Send Message Form -->
                <form id="messageForm" action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data" class="p-2" style="background-color: #f8f9fa; border-radius: 10px;">
                    @csrf
                    <div class="form-group mb-2">
                        <textarea name="message" id="messageBox" placeholder="Type your message..." class="form-control" style="border-radius: 10px;"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                    <p id="error" style="color: red; display: none;">Kindly type a message as messagebox cannot be empty.</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('messageForm').addEventListener('submit', function(event) {
        var message = document.getElementById('messageBox').value.trim();
        
        if (message === "") {
            event.preventDefault();  // Prevent form submission
            document.getElementById('error').style.display = 'block';  // Show error message
        } else {
            document.getElementById('error').style.display = 'none';  // Hide error message if valid
        }
    });
</script>

<style>
    .chat-box {
        background-color: #f1f1f1;
    }
    .sent {
        text-align: right;
    }
    .received {
        text-align: left;
    }
</style>
@endsection

