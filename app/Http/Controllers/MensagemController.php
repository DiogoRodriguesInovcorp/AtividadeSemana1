<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string',
            'sala_id' => 'required|integer',
        ]);

        Mensagem::create([
            'mensagem' => $request->mensagem,
            'user_id' => auth()->id(),
            'sala_id' => $request->sala_id,
        ]);

        return redirect()->route('salas.index', [
            'sala_id' => $request->sala_id
        ]);
    }
}
