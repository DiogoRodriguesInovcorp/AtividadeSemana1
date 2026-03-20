<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $requisicoes = $user->requisicoes()
            ->with('livros')
            ->latest()
            ->paginate(3);

        return view('auth.perfil', compact('user', 'requisicoes'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return back()->with('success','Perfil atualizado');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success','Password atualizada');
    }

    public function updatefoto(Request $request)
    {
        $request->validate([
            'foto_user' => 'image|max:2048'
        ]);

        if($request->hasFile('foto_user')){

            $path = $request->file('foto_user')->store('fotos','public');

            Auth::user()->update([
                'foto_user' => $path
            ]);
        }

        return back();
    }
}
