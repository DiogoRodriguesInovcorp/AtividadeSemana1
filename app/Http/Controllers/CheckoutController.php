<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\Encomenda;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrinho = Auth::user()->carrinho;

        if (!$carrinho || $carrinho->items->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Carrinho vazio');
        }

        $items = $carrinho->items()->with('livro')->get();

        // calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->livro->Preco * $item->quantidade;
        }

        return view('Pagamento_livros.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'morada' => 'required|string|max:255',
        ]);

        $carrinho = Auth::user()->carrinho;

        if (!$carrinho || $carrinho->items->isEmpty()) {
            return back()->with('error', 'Carrinho vazio');
        }

        $items = $carrinho->items()->with('livro')->get();

        // calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->livro->Preco * $item->quantidade;
        }

        // criar encomenda
        $encomenda = Encomenda::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'morada' => $request->morada,
            'estado' => 'pendente',
        ]);

        logAction(
            'Encomendas',
            $encomenda->id,
            'Criou encomenda'
        );

        // foreach ($items as $item) {
        //\App\Models\EncomendaItem::create([
        //    'encomenda_id' => $encomenda->id,
        //    'livro_id' => $item->livro_id,
        //    'quantidade' => $item->quantidade,
        //]);
        //}

        return redirect()->route('checkout.pagamento', $encomenda->id);
    }

    public function pagamento($id)
    {
        $encomenda = \App\Models\Encomenda::findOrFail($id);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Compra de livros',
                        ],
                        'unit_amount' => $encomenda->total * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?id=' . $encomenda->id,
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $encomenda = Encomenda::find($request->id);

        if ($encomenda) {
            $encomenda->update([
                'estado' => 'pago'
            ]);

            $carrinho = $encomenda->user->carrinho;
            if ($carrinho) {
                $carrinho->items()->delete();
            }
        }

        return redirect('/Pagamento_livros/carrinho')
            ->with('success', 'Pagamento efetuado com sucesso!');
    }

    public function cancel()
    {
        return redirect('/Pagamento_livros/carrinho')->with('error', 'Pagamento cancelado.');
    }

    public function encomendas()
    {
        $encomendas = \App\Models\Encomenda::with('user')
            ->latest()
            ->get();

        return view('admin.encomendas', compact('encomendas'));
    }
}
