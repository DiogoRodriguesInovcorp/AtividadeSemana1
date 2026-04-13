<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaConvite;

class ConviteController extends Controller
{
    public function aceitar($conviteId)
    {
        $convite = SalaConvite::findOrFail($conviteId);

        if ($convite->user_id !== auth()->id()) {
            abort(403);
        }

        $convite->update([
            'estado' => 'aceite'
        ]);

        $convite->sala->users()->attach(auth()->id());

        return back();
    }

    public function recusar($conviteId)
    {
        $convite = SalaConvite::findOrFail($conviteId);

        if ($convite->user_id !== auth()->id()) {
            abort(403);
        }

        $convite->update([
            'estado' => 'recusado'
        ]);

        return back();
    }
}
