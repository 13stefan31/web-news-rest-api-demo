<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $authorName;
    public $authorSurname;
    public $postId;
    public $header;
    public $adminName;
    public $adminSurname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($authorName, $authorSurname, $postId, $header, $adminName, $adminSurname)
    {
        //
        $this->postId = $postId;
        $this->header = $header;
        $this->authorName = $authorName;
        $this->authorSurname = $authorSurname;
        $this->adminName = $adminName;
        $this->adminSurname = $adminSurname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.post-accepted');
    }
}
