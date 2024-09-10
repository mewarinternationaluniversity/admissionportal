<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Display the admin inbox with user list
    public function adminInbox()
    {
        $adminId = auth()->id(); // Admin's ID

        // Fetch users who sent messages to the admin
        $users = User::whereHas('messagesSent', function ($query) use ($adminId) {
            $query->where('receiver_id', $adminId);
        })
        ->withCount(['messagesSent' => function ($query) use ($adminId) {
            $query->where('receiver_id', $adminId)->where('is_read', false);
        }])
        ->orderBy('messages_sent_count', 'desc') // Unread messages first
        ->orderBy('updated_at', 'desc') // Sort by latest
        ->get();

        return view('admin.inbox', compact('users'));
    }

    // Get conversation for a specific user
    public function getConversation(Request $request)
    {
        $adminId = auth()->id(); // Admin's ID
        $userId = $request->user_id; // Selected user ID

        // Get conversation between admin and selected user
        $messages = Message::where(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Mark all unread messages as read
        Message::where('receiver_id', $adminId)
            ->where('sender_id', $userId)
            ->update(['is_read' => true]);

        // Return the conversation partial view
        return view('admin.partials.conversation', compact('messages', 'userId'));
    }

    // Display the chatbox for users to send and receive messages with the admin
    public function userChat()
    {
        $admin = User::role('admin')->first(); // Get the first admin
        $messages = Message::where(function($query) use ($admin) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })
        ->where(function($query) use ($admin) {
            $query->where('sender_id', $admin->id)
                  ->orWhere('receiver_id', $admin->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Fetch all users who have sent messages to the current authenticated user
        $users = User::whereHas('messagesSent', function($query) {
            $query->where('receiver_id', Auth::id());
        })->get();

        return view('messages.chat', compact('messages', 'admin', 'users'));
    }

    // Send a message from any user to the admin
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required_without:file',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $admin = User::role('admin')->first(); // Get the admin user

        // Handle file upload if it exists
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        // Create a new message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $request->message,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // Admin reply to user
    public function adminReply(Request $request)
    {
        $request->validate([
            'message' => 'required_without:file',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        // Create new message from admin to the selected user
        Message::create([
            'sender_id' => auth()->id(), // Admin ID
            'receiver_id' => $request->user_id, // Target user ID
            'message' => $request->message,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }
}

