@extends('layouts.l')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Side: User List with Scroll -->
        <div class="col-md-4">
            <div class="card" style="background-color: white; padding: 15px;">
                <div class="search-bar mb-3">
                    <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                </div>

                <div id="userList" class="user-list" style="max-height: calc(100vh - 150px); overflow-y: auto;">
                    @foreach($sortedUsers as $user)
                        <button class="user-item list-group-item" data-user-id="{{ $user->id }}" 
                                data-unread="{{ $user->unread_count }}"
                                data-last-message="{{ $user->last_message_time }}"
                                style="cursor: pointer; width: 100%; text-align: left;">
                            <strong>{{ $user->name }} (Last message: {{ $user->last_message_time }})</strong>
                            @if($user->unread_count > 0)
                                <span class="badge bg-danger float-right">{{ $user->unread_count }} unread</span>
                            @endif
                        </button>
                    @endforeach

                    @if($sortedUsers->hasPages())
                        <div class="pagination-container mt-3">
                            {{ $sortedUsers->links() }}
                        </div>
                    @endif
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

                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" style="display: none; text-align: center; padding: 20px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Load More Messages Button -->
                    <div id="loadMoreContainer" style="display: none; text-align: center; padding: 10px;">
                        <button id="loadMoreMessages" class="btn btn-sm btn-outline-secondary">Load More Messages</button>
                    </div>

                    <!-- Message Reply Box -->
                    <div id="replyBox" class="reply-box" style="display: none;">
                        <form id="replyForm" action="{{ route('message.reply') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="selectedUserId">
                            <div class="input-group">
                                <textarea name="message" id="messageInput" class="form-control" placeholder="Type your reply..."></textarea>
                                <input type="file" name="file" id="fileInput" class="form-control-file">
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

    /* File attachment styles */
    .file-attachment {
        display: flex;
        align-items: center;
        margin-top: 5px;
        padding: 5px;
        background-color: #f1f1f1;
        border-radius: 5px;
    }
    
    .file-attachment i {
        margin-right: 5px;
    }
</style>

<!-- jQuery should be loaded first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        let currentUserId = null;
        let currentPage = 1;
        let canLoadMore = true;
        
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
            
            // Reset pagination when switching users
            currentUserId = userId;
            currentPage = 1;
            canLoadMore = true;
            
            loadConversation(userId, 1, true);
            
            // Highlight selected user
            $('.user-item').removeClass('active');
            $(this).addClass('active');
            
            // Clear unread badge
            $(this).find('.badge').remove();
            
            // Mark messages as read
            markMessagesAsRead(userId);
        });

        // Search in the conversation
        $('#conversationSearch').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('#conversationMessages .message').each(function() {
                var messageText = $(this).text().toLowerCase();
                $(this).toggle(messageText.includes(searchTerm));
            });
        });
        
        // Load more messages
        $(document).on('click', '#loadMoreMessages', function() {
            if (canLoadMore && currentUserId) {
                currentPage++;
                loadConversation(currentUserId, currentPage, false);
            }
        });

        // Handle form submission with AJAX
        $('#replyForm').submit(function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Sending...');
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Clear the input fields
                    $('#messageInput').val('');
                    $('#fileInput').val('');
                    
                    // Reload the conversation to show the new message
                    loadConversation(currentUserId, 1, true);
                },
                error: function(xhr) {
                    console.error('Error sending message:', xhr.responseText);
                    alert('Failed to send message. Please try again.');
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Load conversation function with pagination
        function loadConversation(userId, page, resetContent) {
            console.log('Loading conversation for user:', userId, 'page:', page);
            
            // Show loading indicator
            $('#loadingIndicator').show();
            
            if (resetContent) {
                $('#conversationMessages').html('');
                $('#loadMoreContainer').hide();
            }

            $.ajax({
                url: '{{ route('admin.getConversation') }}',
                method: 'GET',
                data: { 
                    user_id: userId,
                    page: page
                },
                success: function(data) {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                    
                    if (resetContent) {
                        $('#conversationMessages').html(data.html);
                    } else {
                        // Prepend older messages to the top
                        $('#conversationMessages').prepend(data.html);
                    }
                    
                    $('#selectedUserId').val(userId);
                    $('#replyBox').show();
                    
                    // Update load more button visibility
                    canLoadMore = data.has_more;
                    $('#loadMoreContainer').toggle(canLoadMore);
                    
                    // Fetch and display user details
                    loadUserInfo(userId);

                    // Scroll to the bottom of the conversation if it's the first load
                    if (resetContent) {
                        var conversationMessages = document.getElementById('conversationMessages');
                        conversationMessages.scrollTop = conversationMessages.scrollHeight;
                    }
                },
                error: function(xhr, status, error) {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                    
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
                    $('#phone').text(user.phone || 'Not provided');
                    $('#userInfo').show();
                },
                error: function() {
                    console.error('Error loading user info');
                }
            });
        }
        
        // Mark messages as read
        function markMessagesAsRead(userId) {
            $.ajax({
                url: '{{ route('admin.markMessagesAsRead') }}',
                method: 'POST',
                data: { 
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                error: function(xhr) {
                    console.error('Error marking messages as read:', xhr.responseText);
                }
            });
        }
        
        // Check for new messages periodically
        function checkForNewMessages() {
            if (currentUserId) {
                $.ajax({
                    url: '{{ route('admin.checkNewMessages') }}',
                    method: 'GET',
                    data: { user_id: currentUserId },
                    success: function(data) {
                        if (data.has_new) {
                            // Reload the current conversation
                            loadConversation(currentUserId, 1, true);
                        }
                    }
                });
            }
            
            // Update unread counts for all users
            $.ajax({
                url: '{{ route('admin.getUnreadCounts') }}',
                method: 'GET',
                success: function(data) {
                    // Update unread badges
                    $.each(data, function(userId, count) {
                        const userItem = $(`.user-item[data-user-id="${userId}"]`);
                        userItem.find('.badge').remove();
                        
                        if (count > 0) {
                            userItem.append(`<span class="badge bg-danger float-right">${count} unread</span>`);
                        }
                    });
                }
            });
        }
        
        // Check for new messages every 30 seconds
        setInterval(checkForNewMessages, 30000);
    });
</script>
@endsection


