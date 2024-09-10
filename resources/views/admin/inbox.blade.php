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
                    <!-- User Info Section -->
                    <div id="userInfo" class="user-info mb-3" style="display: none;">
                        <strong>Name:</strong> <span id="username"></span> | 
                        <strong>Email:</strong> <span id="email"></span> | 
                        <strong>Phone:</strong> <span id="phone"></span>
                    </div>

                    <!-- Search Conversation -->
                    <div class="search-conversation mb-3">
                        <input type="text" id="conversationSearch" class="form-control" placeholder="Search conversation...">
                    </div>

                    <!-- Conversation Messages -->
                    <div id="conversationMessages" class="conversation-messages" style="height: 400px; overflow-y: auto; padding: 15px; background-color: #ffffff;">
                        <p>Select a user to start a conversation.</p>
                    </div>

                    <!-- Message Reply Box -->
                    <div id="replyBox" class="reply-box" style="display: none;">
                        <form id="replyForm" action="{{ route('message.reply') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="selectedUserId">
                            <div class="input-group">
                                <textarea name="message" id="messageInput" class="form-control" placeholder="Type your reply..."></textarea>
                                <input type="file" name="file" class="form-control-file">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles for better layout -->
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
        margin-bottom: 50px; /* Reserve space for the reply box */
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

    .reply-box {
        padding: 10px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .user-info {
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
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
            console.log('Loading conversation for user:', userId);

            $.ajax({
                url: '{{ route('admin.getConversation') }}',
                method: 'GET',
                data: { user_id: userId },
                success: function(data) {
                    $('#conversationMessages').html(data);
                    $('#selectedUserId').val(userId);
                    $('#replyBox').show();
                    console.log('Conversation loaded successfully');

                    // Fetch and display user details
                    loadUserInfo(userId);

                    // Scroll to the bottom of the conversation
                    var conversationMessages = document.getElementById('conversationMessages');
                    conversationMessages.scrollTop = conversationMessages.scrollHeight;
                },
                error: function(xhr, status, error) {
                    $('#conversationMessages').html('<p>Could not load conversation. Please try again later.</p>');
                    console.error('Error loading conversation:', status, error);
                }
            });
        }

        // Load user info
        function loadUserInfo(userId) {
            $.ajax({
                url: '{{ route('admin.getUserInfo') }}',
                method: 'GET',
                data: { user_id: userId },
                success: function(user) {
                    $('#username').text(user.name);
                    $('#email').text(user.email);
                    $('#phone').text(user.phone);
                    $('#userInfo').show();
                },
                error: function() {
                    console.error('Error loading user info');
                }
            });
        }
    });
</script>
@endsection

