<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'message', 
        'file_path', 
        'is_read'
    ];

    /**
     * Define the relationship with the sender (User model).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Define the relationship with the receiver (User model).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Check if the message has been read.
     */
    public function isRead()
    {
        return $this->is_read;
    }
}

