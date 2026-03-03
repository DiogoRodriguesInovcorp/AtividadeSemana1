<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutoresRequest;
use App\Http\Requests\EditorasRequest;
use App\Http\Requests\LivroRequest;
use App\Models\Autores;
use App\Models\Editoras;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function criarlivros()
    {
        $editoras = Editoras::all();
        $autores = Autores::all();

        return view('admin.criar-livros', compact('editoras', 'autores'));
    }

    public function storelivros(LivroRequest $request)
    {
        $path = $request->file('Imagem_da_capa')->store('livros', 'public');

        $livro = Livro::create([
            'ISBN' => $request->ISBN,
            'Nome_livro' => $request->Nome_livro,
            'Editora_id' => $request->Editora_id,
            'Bibliografia' => $request->Bibliografia,
            'Imagem_da_capa' => $path,
            'Preco' => $request->Preco,
        ]);

        $livro->autores()->attach($request->autores);

        return redirect()->back()->with('success', 'Livro colocado com sucesso!');
    }

    public function criarautores()
    {
        return view('admin.criar-autores');
    }

    public function storeautores(AutoresRequest $request)
    {

        $path = $request->file('Foto_autor')->store('autores', 'public');

        Autores::create([
            'Nome_autor' => $request->Nome_autor,
            'Foto_autor' => $path,
        ]);

        return redirect()->back()->with('success', 'Autor/a colocado/a com sucesso!');
    }

    public function criareditoras()
    {
        return view('admin.criar-editoras');
    }

    public function storeeditoras(EditorasRequest $request)
    {
        $path = $request->file('Logo_editora')->store('editoras', 'public');

        Editoras::create([
            'Nome_editora' => $request->Nome_editora,
            'Logo_editora' => $path,
        ]);

        return redirect()->back()->with('success', 'Editora colocada com sucesso!');
    }

    public function destroy(Livro $livro)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $livro->delete();

        return redirect()->back()->with('success', 'Livro eliminado com sucesso.');
    }

    public function criarAdmin()
    {
        return view('admin.criar-admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'bibliotecario',
        ]);

        return redirect()->route('admin.criar-admin')->with('success', 'Novo Admin criado com sucesso!');
    }
}
