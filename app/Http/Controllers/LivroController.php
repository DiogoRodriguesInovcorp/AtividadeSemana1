<?php

namespace App\Http\Controllers;


use App\Models\AlertasDisponibilidade;
use App\Models\Autores;
use App\Models\Editoras;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LivroController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function livros(Request $request)
    {
        $query = Livro::with('autores', 'editoras');

        if ($request->filled('search')) {
            $query->where('Nome_livro', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('editora')) {
            $query->where('Editora_id', $request->editora);
        }

        if ($request->filled('sort')) {
            $direction = $request->get('direction', 'asc');
            $query->orderBy($request->sort, $direction);
        }

        $livros = $query->paginate(3)->withQueryString();

        $editoras = Editoras::all();
        $autores = Autores::all();

        return view('livros.livros', [
            'livros' => $livros,
            'editoras' => $editoras,
            'autores' => $autores
        ]);
    }
    public function autores(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'Nome_autor');
        $direction = $request->get('direction', 'asc');

        $autores = Autores::with('livros')
            ->when($search, fn($q) => $q->where('Nome_autor', 'like', "%{$search}%"))
            ->orderBy($sort, $direction)
            ->paginate(3)
            ->withQueryString();

        return view('livros.autores', compact('autores'));
    }

    public function editoras(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'Nome_editora');
        $direction = $request->get('direction', 'asc');

        $editoras = Editoras::with('livros')
            ->when($search, fn($q) => $q->where('Nome_editora', 'like', "%{$search}%"))
            ->orderBy($sort, $direction)
            ->paginate(3)
            ->withQueryString();

        return view('livros.editoras', compact('editoras'));
    }

    public function criar()
    {
        return view('admin.criar');
    }

    public function show(Livro $livro)
    {
        $livro->load('autores', 'editoras');

        $reviews = $livro->reviews()
            ->where('estado','ativo')
            ->with('user')
            ->get();

        $historico = $livro->requisicoes()
            ->with('user')
            ->whereHas('user')
            ->latest()
            ->paginate(3);

        $autorIds = $livro->autores->pluck('id')->toArray();

        $livrosRelacionados = \App\Models\Livro::where('id', '!=', $livro->id)
            ->whereHas('autores', function($query) use ($autorIds) {
                $query->whereIn('autores.id', $autorIds);
            })
            ->with('autores', 'editoras')
            ->get();

        return view('livros.show-livros', compact('livro', 'reviews', 'historico', 'livrosRelacionados'));
    }

    public function showautores(Autores $autor)
    {
        $livros = $autor->livros()->with('editoras', 'autores')->get();

        return view('livros.show-autores', compact('autor', 'livros'));
    }

    public function showeditoras(Editoras $editora)
    {
        $livros = $editora->livros()->with('editoras', 'autores')->get();

        return view('livros.show-editoras', compact('editora', 'livros'));
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/index');
    }

    public function marcarDisponivel(Livro $livro)
    {
        $livro->update(['disponivel' => true]);

        // Pega todos os alertas desse livro
        $alertas = AlertasDisponibilidade::where('livro_id', $livro->id)->get();

        foreach($alertas as $alerta) {
            Mail::raw("O livro '{$livro->Nome_livro}' já está disponível! Corra para requisitar!", function($message) use ($alerta) {
                $message->to($alerta->user->email)
                    ->subject('Livro Disponível');
            });
        }

        // Limpa os alertas do banco
        AlertasDisponibilidade::where('livro_id', $livro->id)->delete();

        return back()->with('success', 'Livro marcado como disponível e usuários notificados!');
    }
}
