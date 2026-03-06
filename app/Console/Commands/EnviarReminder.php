<?php

namespace App\Console\Commands;

use App\Models\Requisicao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEntregaMail;

class EnviarReminder extends Command
{
    protected $signature = 'app:enviar-reminder';
    protected $description = 'Enviar emails de reminder 1 dia antes da devolução';

    public function handle()
    {
        $requisicoes = Requisicao::whereDate('data_prevista_entrega', now()->addDay())
            ->where('estado','ativa')
            ->get();

        foreach($requisicoes as $r){
            Mail::to($r->user->email)
                ->send(new ReminderEntregaMail($r));
        }

        $this->info('Reminders enviados com sucesso!');
    }
}
