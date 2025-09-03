<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
   // app/Mail/AdminReplyNotification.php

public function build()
{
    return $this->from('hnd@nbte.gov.ng')
                ->subject('A reply has been given by NBTE HND Help Desk')
                ->view('emails.admin_reply') // referencing the correct view in the emails folder
                ->with([
                    'user' => $this->user,
                ]);
}

}



