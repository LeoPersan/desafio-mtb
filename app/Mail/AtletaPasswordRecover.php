<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AtletaPasswordRecover extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->subscription->email, $this->subscription->nome_strava)
        // return $this->to('leopso1990@gmail.com', $this->subscription->nome_strava)
            ->replyTo(config('mail.from.address'), config('mail.from.name'))
            ->subject(config('app.name') . ' - Recuperar senha')
            ->markdown('emails.atleta.password_recover', ['subscription'=>$this->subscription]);
    }
}
