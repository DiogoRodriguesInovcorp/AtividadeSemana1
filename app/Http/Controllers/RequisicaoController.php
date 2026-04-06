<?php

namespace App\Http\Controllers;

use App\Mail\RequisicaoCriada;
use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Requisicao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RequisicaoController extends Controller
{
    public function store(Livro $livro)
    {

        $request = request();

        $request->validate([
            'livro_id' => 'required|exists:livros,id'
        ]);
        $livro = Livro::findOrFail($request->livro_id);

        $user = auth()->user();

        if ($livro->disponivel <= 0) {
            return back()->withErrors(['livro_id' => 'Livro indisponível.']);
        }

        if ($user->requisicoes()->where('estado','ativa')->count() >= 3) {
            return back()->with('error', 'Já atingiu o número máximo de livros que pode requisitar.');
        }

        $livro->disponivel -= 1;
        $livro->save();

        $requisicao = Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'estado' => 'ativa',
            'data_requisicao' => now(),
            'data_prevista_entrega' => now()->addDays(5),
            'codigo' => (int) Requisicao::max('codigo') + 1,
        ]);

        logAction(
            'Requisições',
            $requisicao->id,
            'Criou uma requisição'
        );

        Mail::to($user->email)->send(new RequisicaoCriada($requisicao));
        Mail::to('rodriguesdidi25@gmail.com')->send(new RequisicaoCriada($requisicao));

        return redirect()->back()->with('success', 'Livro requisitado com sucesso!');
    }

    public function index()
    {
        $user = auth()->user();

        $requisicoes = $user->requisicoes()
            ->with('livros')
            ->latest()
            ->wherehas('user')
            ->paginate(3);

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
            ->wherehas('user')
            ->paginate(3);

        $indicadores = [
            'ativas' => Requisicao::where('estado', 'ativa')->count(),
            'ultimos_30_dias' => Requisicao::where('data_requisicao', '>=', now()->subDays(30))->count(),
            'entregues_hoje' => Requisicao::whereDate('data_entrega_real', now())->count(),
        ];

        return view('admin.requisicoes-todas', compact('requisicoes', 'indicadores'));
    }

    public function devolver($id)
    {
        // Pega a requisição
        $req = Requisicao::findOrFail($id);

        // Marca como devolvido
        $req->estado = 'devolvido';
        $req->data_entrega_real = now();
        $req->dias_decorridos = $req->data_requisicao->diffInDays(now());
        $req->save();

        logAction(
            'Requisições',
            $req->id,
            'Devolveu um livro'
        );

        // Marca o livro como disponível
        $livro = Livro::findOrFail($req->livro_id);
        $livro->disponivel += 1;
        $livro->save();

        // Busca alertas do livro
        $alertas = \App\Models\AlertasDisponibilidade::where('livro_id', $livro->id)->get();

        // Envia email para cada usuário que clicou no sino
        foreach ($alertas as $alerta) {
            if($alerta->user && $alerta->user->email) {
                \Illuminate\Support\Facades\Mail::raw(
                    "O livro '{$livro->Nome_livro}' já está disponível para requisição!",
                    function($message) use ($alerta) {
                        $message->to($alerta->user->email)
                            ->subject("Livro Disponível");
                    }
                );
            }
        }

        // Limpa os alertas do livro
        \App\Models\AlertasDisponibilidade::where('livro_id', $livro->id)->delete();

        return back()->with('success', 'Livro devolvido com sucesso e usuários notificados!');
    }
}
