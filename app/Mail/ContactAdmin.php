<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($request, $token)
    {
        $this->request = $request;
        $this->token = $token;
    }

    public function build()
    {
        return $this->to(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->request->get('email'), $this->request->get('nome'))
            ->subject(config('app.name') . ' - Contato de ' . $this->request->get('nome') . '! #' . $this->token)
            ->markdown('emails.contact_admin', $this->request->all());
    }
}
