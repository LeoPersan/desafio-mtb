<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUser extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($request, $token)
    {
        $this->request = $request;
        $this->token = $token;
    }

    public function build()
    {
        return $this->to($this->request->get('email'), $this->request->get('nome'))
            ->replyTo(config('mail.from.address'), config('mail.from.name'))
            ->subject(config('app.name') . ' - Contato de ' . $this->request->get('nome') . '! #' . $this->token)
            ->markdown('emails.contact_user', $this->request->all());
    }
}
