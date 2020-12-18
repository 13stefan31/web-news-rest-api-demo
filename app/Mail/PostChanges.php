<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostChanges extends Mailable
{
    use Queueable, SerializesModels;

    public $authorName;
    public $authorSurname;
    public $postId;
    public $header;
    public $changes;
    public $adminName;
    public $adminSurname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($authorName, $authorSurname, $postId, $header, $changes, $adminName, $adminSurname)
    {
        //
        $this->authorName = $authorName;
        $this->authorSurname = $authorSurname;
        $this->postId = $postId;
        $this->header = $header;
        $this->changes = $changes;
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
        return $this->view('emails.post-change');
    }
}
