<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('hnd@nbte.gov.ng', 'NBTE HND Help Desk') // Correctly configure the sender
                    ->subject('A reply has been given by NBTE HND Help Desk')
                    ->view('emails.admin_reply') // Ensure the view file is correctly named and placed in resources/views/emails
                    ->with([
                        'user' => $this->user,
                    ]);
    }
}

