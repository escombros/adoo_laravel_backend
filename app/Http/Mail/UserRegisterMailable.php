<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class UserRegisterMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Resgistro FUD";
    public $email;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$id)
    {
        
        $this->email = $email;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        log::info('apunto de enviar');
        return $this->view('emails.userregister');
    }
}
