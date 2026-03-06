<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEntregaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requisicao;

    public function __construct($requisicao)
    {
        $this->requisicao = $requisicao;
    }

    public function build()
    {
        return $this->subject('Lembrete de Devolução')
            ->markdown('emails.requisicao.reminder');
    }
}
