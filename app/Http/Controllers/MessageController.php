<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    // Display the admin inbox with user list
    public function adminInbox()
    {
        $adminId = auth()->id(); // Admin's ID
        
        // Get users with their last message time and unread count
        $sortedUsers = User::where('id', '!=', $adminId)
            ->whereHas('messagesSent', function ($query) use ($adminId) {
                $query->where('receiver_id', $adminId);
            })
            ->orWhereHas('messagesReceived', function ($query) use ($adminId) {
                $query->where('sender_id', $adminId);
            })
            ->select('users.*')
            // Add unread count as a subquery
            ->selectSub(function ($query) use ($adminId) {
                $query->from('messages')
                    ->selectRaw('COUNT(*)')
                    ->whereRaw('sender_id = users.id AND receiver_id = ? AND is_read = 0', [$adminId]);
            }, 'unread_count')
            ->selectSub(function ($query) use ($adminId) {
                $query->from('messages')
                    ->selectRaw('MAX(created_at)')
                    ->whereRaw('(sender_id = users.id AND receiver_id = ?) OR (receiver_id = users.id AND sender_id = ?)', [$adminId, $adminId]);
            }, 'last_message_time_raw')
            ->selectSub(function ($query) use ($adminId) {
                $query->from('messages')
                    ->selectRaw("COALESCE(DATE_FORMAT(MAX(created_at), '%Y-%m-%d %H:%i:%s'), 'No messages yet')")
                    ->whereRaw('(sender_id = users.id AND receiver_id = ?) OR (receiver_id = users.id AND sender_id = ?)', [$adminId, $adminId]);
            }, 'last_message_time')
            ->orderByDesc('unread_count')
            ->orderByDesc('last_message_time_raw')
            ->paginate(20);
        
        return view('admin.inbox', compact('sortedUsers'));
    }

    // Get conversation for a specific user with pagination
    public function getConversation(Request $request)
    {
        $adminId = auth()->id();
        $userId = $request->user_id;
        $page = $request->input('page', 1);
        $perPage = 20; // Messages per page
        
        // Get messages with pagination
        $messages = Message::where(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $userId);
        })
        ->orderByDesc('created_at')
        ->paginate($perPage, ['*'], 'page', $page);
        
        // Reverse the collection to show oldest messages first
        $messages->setCollection($messages->getCollection()->reverse());
        
        // Determine if there are more pages
        $hasMore = $messages->hasMorePages() && $page > 1;
        
        // Mark messages as read if this is the first page
        if ($page == 1) {
            Message::where('receiver_id', $adminId)
                ->where('sender_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        
        // Return HTML for AJAX
        $html = view('admin.partials.conversation', compact('messages', 'userId', 'adminId'))->render();
        
        return response()->json([
            'html' => $html,
            'has_more' => $hasMore,
            'current_page' => $page,
        ]);
    }

    // Fetch user information (username, email, phone) for admin display
    public function getUserInfo(Request $request)
    {
        $user = User::find($request->user_id);
        return response()->json($user);
    }

    // Display the chatbox for users to send and receive messages with the admin
    public function userChat()
    {
        $admin = User::role('admin')->first();
        
        // Get paginated messages
        $messages = Message::where(function($query) use ($admin) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $admin->id);
        })
        ->orWhere(function($query) use ($admin) {
            $query->where('sender_id', $admin->id)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        // Reverse to show oldest first
        $messages->setCollection($messages->getCollection()->reverse());

        // Mark all messages from admin as read
        Message::where('receiver_id', Auth::id())
              ->where('sender_id', $admin->id)
              ->where('is_read', false)
              ->update(['is_read' => true]);
        
        return view('messages.chat', compact('messages', 'admin'));
    }

    // Send a message from any user to the admin
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required_without:file',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $admin = User::role('admin')->first();

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $request->message,
            'file_path' => $filePath,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // Admin reply to user
    public function adminReply(Request $request)
    {
        $request->validate([
            'message' => 'required_without:file',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->user_id,
            'message' => $request->message,
            'file_path' => $filePath,
            'is_read' => false,
        ]);

        // Send email notification to user
        $user = User::find($request->user_id);
        if ($user && $user->email) {
            try {
                Mail::to($user->email)->send(new AdminReplyNotification($user, $message));
            } catch (\Exception $e) {
                // Log error but don't stop execution
                \Log::error('Failed to send email notification: ' . $e->getMessage());
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Reply sent successfully']);
        }

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }
    
    // Mark messages as read
    public function markMessagesAsRead(Request $request)
    {
        $adminId = auth()->id();
        $userId = $request->user_id;
        
        Message::where('receiver_id', $adminId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
    
    // Check for new messages
    public function checkNewMessages(Request $request)
    {
        $adminId = auth()->id();
        $userId = $request->user_id;
        
        $hasNew = Message::where('receiver_id', $adminId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->exists();
            
        return response()->json(['has_new' => $hasNew]);
    }
    
    // Get unread counts for all users
    public function getUnreadCounts()
    {
        $adminId = auth()->id();
        
        $unreadCounts = Message::where('receiver_id', $adminId)
            ->where('is_read', false)
            ->selectRaw('sender_id, COUNT(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id')
            ->toArray();
            
        return response()->json($unreadCounts);
    }
}


