@extends('layouts.l')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Side: User List -->
        <div class="col-md-4">
            <div class="card" style="background-color: white; padding: 15px;">
                <div class="search-bar mb-3">
                    <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                </div>

                <div id="userList" class="user-list">
                    @foreach($users as $user)
                        <!-- Updated to button with an ID -->
                        <button class="user-item list-group-item" data-user-id="{{ $user->id }}" style="cursor: pointer; width: 100%; text-align: left;">
                            <strong>{{ $user->name }}</strong>
                            @if($user->messages_sent_count > 0)
                                <span class="badge bg-danger">{{ $user->messages_sent_count }} unread</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Side: Conversation -->
        <div class="col-md-8">
            <div class="card" style="background-color: white; padding: 15px;">
                <div id="conversationContainer">
                    <div class="search-conversation mb-3">
                        <input type="text" id="conversationSearch" class="form-control" placeholder="Search conversation...">
                    </div>
                    <div id="conversationMessages" class="conversation-messages" style="height: 400px; overflow-y: scroll; padding: 15px; background-color: #ffffff;">
                        <!-- Messages will load here when a user is selected -->
                        <p>Select a user to start a conversation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline styles for better visibility -->
<style>
    .user-item {
        background-color: #f8f9fa;
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .user-item.active {
        background-color: #e9ecef;
    }

    .conversation-messages {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }

    .message.sent {
        text-align: right;
        background-color: #d1e7dd;
        padding: 8px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .message.received {
        text-align: left;
        background-color: #f8d7da;
        padding: 8px;
        border-radius: 10px;
        margin-bottom: 10px;
    }
</style>

<!-- jQuery should be loaded first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        // User search functionality
        $('#userSearch').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.user-item').each(function() {
                var userName = $(this).text().toLowerCase();
                $(this).toggle(userName.includes(searchTerm));
            });
        });

        // Use event delegation to ensure click event works even with dynamically rendered elements
        $(document).on('click', '.user-item', function() {
            var userId = $(this).data('user-id');
            loadConversation(userId);
            
            // Highlight selected user
            $('.user-item').removeClass('active');
            $(this).addClass('active');
        });

        // Search in the conversation
        $('#conversationSearch').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('#conversationMessages .message').each(function() {
                var messageText = $(this).text().toLowerCase();
                $(this).toggle(messageText.includes(searchTerm));
            });
        });

        // Load conversation function
        function loadConversation(userId) {
            console.log('Loading conversation for user:', userId); // Debugging log

            $.ajax({
                url: '{{ route('admin.getConversation') }}',
                method: 'GET',
                data: { user_id: userId },
                success: function(data) {
                    $('#conversationMessages').html(data);
                    console.log('Conversation loaded successfully'); // Debugging log
                },
                error: function(xhr, status, error) {
                    $('#conversationMessages').html('<p>Could not load conversation. Please try again later.</p>');
                    console.error('Error loading conversation:', status, error); // Debugging log
                }
            });
        }
    });
</script>
@endsection

