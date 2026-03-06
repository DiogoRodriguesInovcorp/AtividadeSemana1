<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Requisicao;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReminderEntrega extends Command
{
    protected $signature = 'reminder:envio';

    protected $description = 'Envia emails de reminder 1 dia antes da data de entrega';

    public function handle()
    {
        $requisicoes = Requisicao::whereDate('data_prevista_entrega', Carbon::tomorrow())
            ->where('estado', 'ativa')
            ->get();

        foreach($requisicoes as $r){
            Mail::to($r->user->email)->send(new ReminderEntrega($r));
        }

        $this->info('Emails de reminder enviados com sucesso!');
    }
}
