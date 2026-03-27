<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Carrinho;
use Illuminate\Support\Facades\Mail;

class CarrinhoAbandonadoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $carrinhos = Carrinho::whereHas('items')
            ->where('updated_at', '<=', now()->subHour())
            ->get();

        foreach ($carrinhos as $carrinho) {

            $user = $carrinho->user;

            Mail::raw(
                "Tem livros no carrinho há mais de 1h. Precisa de ajuda para finalizar a compra?",
                function($msg) use ($user){
                    $msg->to($user->email)
                        ->subject('Carrinho pendente');
                }
            );
        }
    }
}
