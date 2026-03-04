<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Requisicao;
use Carbon\Carbon;

class RequisicaoController extends Controller
{
    public function store(Livro $livro)
    {
        $user = auth()->user();

        if (!$livro->estaDisponivel()) {
            return back()->withErrors('Livro indisponível.');
        }

        if ($user->requisicoes()->where('estado','ativa')->count() >= 3) {
            return back()->with('error', 'Já atingiu o número máximo de livros que pode registar.');
        }

        Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'estado' => 'ativa',
            'data_requisicao' => now(),
            'data_prevista_entrega' => now()->addDays(5),
            'codigo' => (int) Requisicao::max('codigo') + 1,
        ]);

        return redirect()->back()->with('success', 'Livro requisitado com sucesso!');
    }

    public function index()
    {
        $user = auth()->user();

        $requisicoes = $user->requisicoes()
            ->with('livros')
            ->latest()
            ->get();

        return view('livros.requisicoes', compact('requisicoes'));
    }

    public function confirmar(Requisicao $requisicao)
    {
        $requisicao->update([
            'estado' => 'entregue',
            'data_entrega_real' => now(),
            'dias_decorridos' => now()->diffInDays($requisicao->data_requisicao),
        ]);

        return redirect()->back()->with('success', 'Requisição confirmada!');
    }

    public function todas()
    {
        $requisicoes = Requisicao::with('livros', 'user')
            ->latest()
            ->get();

        $indicadores = [
            'ativas' => Requisicao::where('estado', 'ativa')->count(),
            'ultimos_30_dias' => Requisicao::where('data_requisicao', '>=', now()->subDays(30))->count(),
            'entregues_hoje' => Requisicao::whereDate('data_entrega_real', now())->count(),
        ];

        return view('admin.requisicoes-todas', compact('requisicoes', 'indicadores'));
    }
}
