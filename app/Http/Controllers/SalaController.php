<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use App\Models\SalaConvite;
use App\Models\User;

class SalaController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', auth()->id())->get();

        if (auth()->user()->permissao === 'admin') {
            $salas = Sala::all();
        } else {
            $salas = auth()->user()->salas;
        }

        $salaSelecionada = null;
        $mensagens = [];

        $convites = collect();
        $notificacoesPendentes = 0;

        $convites = SalaConvite::where('user_id', auth()->id())
            ->where('estado', 'pendente')
            ->with('sala')
            ->get();

        $notificacoesPendentes = $convites->count();

        if ($request->sala_id) {

            $salaSelecionada = Sala::find($request->sala_id);

            if (!$salaSelecionada->users->contains(auth()->id())
                && auth()->user()->permissao !== 'admin') {

                abort(403, 'Não tens acesso a esta sala.');
            }



            $mensagens = $salaSelecionada
                ? $salaSelecionada->mensagens()->with('user')->get()
                : [];
        }

        return view('salas.index', compact('salas', 'salaSelecionada', 'mensagens', 'notificacoesPendentes', 'convites', 'users'));
    }

    public function create()
    {
        return view('salas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Sala::create([
            'nome' => $request->nome,
        ]);

        return redirect()->route('salas.index');
    }

    public function destroy(Sala $sala)
    {
        $sala->delete();
        return redirect()->route('salas.index');
    }

    public function convidar(Request $request, Sala $sala)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $exists = SalaConvite::where('sala_id', $sala->id)
            ->where('user_id', $request->user_id)
            ->where('estado', 'pendente')
            ->exists();

        if ($exists) {
            return back();
        }

        SalaConvite::create([
            'sala_id' => $sala->id,
            'user_id' => $request->user_id,
            'estado' => 'pendente'
        ]);

        return back();
    }
}
