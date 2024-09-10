@foreach($messages as $message)
    <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
        <p>{{ $message->message }}</p>
        @if($message->file_path)
            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">View Attachment</a>
        @endif
        <span class="time">{{ $message->created_at->diffForHumans() }}</span>
    </div>
@endforeach

<!-- Message reply form -->
<div class="reply-box">
    <form action="{{ route('message.reply') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId ?? '' }}"> <!-- Hidden field for user_id -->
        <div class="input-group">
            <textarea name="message" class="form-control" placeholder="Type your reply..."></textarea>
            <input type="file" name="file" class="form-control-file">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>

<!-- Styling to make the message box look nice -->
<style>
    .reply-box {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .input-group {
        margin-top: 10px;
    }

    .message {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        background-color: #f1f1f1;
    }

    .sent {
        background-color: #d1e7dd;
        text-align: right;
    }

    .received {
        background-color: #f8d7da;
    }

    .conversation-messages {
        max-height: 400px;
        overflow-y: auto;
    }
</style>

