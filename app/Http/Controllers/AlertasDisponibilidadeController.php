<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertasDisponibilidade;
use Illuminate\Support\Facades\Auth;

class AlertasDisponibilidadeController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $livroId = $request->livro_id;

        // Verifica se já existe alerta para este utilizador e livro
        $existe = AlertasDisponibilidade::where('user_id', $user->id)
            ->where('livro_id', $livroId)
            ->first();

        if ($existe) {
            return back()->with('error', 'Você já se notificou para este livro! Aguarde o email.');
        }

        AlertasDisponibilidade::create([
            'user_id' => Auth::id(),
            'livro_id' => $request->livro_id
        ]);

        return back()->with('success', '🔔 Você será notificado quando o livro estiver disponível!');
    }
}
