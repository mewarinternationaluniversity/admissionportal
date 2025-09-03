@foreach($messages as $message)
    <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
        <div class="message-content">
            <p>{{ $message->message }}</p>
            @if($message->file_path)
                <div class="file-attachment">
                    <i class="mdi mdi-attachment"></i>
                    <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">
                        {{ basename($message->file_path) }}
                    </a>
                </div>
            @endif
        </div>
        <small class="time text-muted">{{ $message->created_at->diffForHumans() }}</small>
    </div>
@endforeach

@if($messages->isEmpty())
    <div class="text-center p-4">
        <p class="text-muted">No messages yet. Start a conversation!</p>
    </div>
@endif

<style>
    .message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 10px;
        max-width: 80%;
        position: relative;
        clear: both;
    }

    .sent {
        background-color: #d1e7dd;
        float: right;
        border-bottom-right-radius: 0;
    }

    .received {
        background-color: #f8d7da;
        float: left;
        border-bottom-left-radius: 0;
    }

    .message-content {
        word-break: break-word;
    }

    .message p {
        margin-bottom: 5px;
    }

    .time {
        display: block;
        font-size: 0.8em;
        margin-top: 5px;
    }

    .file-attachment {
        background-color: rgba(255, 255, 255, 0.5);
        padding: 5px;
        border-radius: 5px;
        margin-top: 5px;
        display: flex;
        align-items: center;
    }

    .file-attachment i {
        margin-right: 5px;
    }
    
    /* Clear fix for floating elements */
    .message:after {
        content: "";
        display: table;
        clear: both;
    }
</style>


