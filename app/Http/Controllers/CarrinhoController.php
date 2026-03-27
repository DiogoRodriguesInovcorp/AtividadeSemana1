<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Http\Request;
use App\Models\CarrinhoItem;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function adicionar($livroId)
    {
        $user = Auth::user();

        $carrinho = Carrinho::firstOrCreate([
            'user_id' => $user->id
        ]);

        $item = $carrinho->items()->where('livro_id', $livroId)->first();

        if ($item) {
            $item->increment('quantidade');
        } else {
            $carrinho->items()->create([
                'livro_id' => $livroId,
                'quantidade' => 1
            ]);
        }

        return back()->with('success', 'Livro adicionado ao carrinho');
    }

    public function index()
    {
        $carrinho = Auth::user()->carrinho;

        $items = $carrinho
            ? $carrinho->items()->with('livro')->get()
            : collect();

        return view('Pagamento_livros.carrinho', compact('items'));
    }

    public function remover($id)
    {
        CarrinhoItem::findOrFail($id)->delete();
        return back();
    }
}
