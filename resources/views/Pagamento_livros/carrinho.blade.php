<x-layout>

    <h1 class="text-3xl font-bold mb-6">O Seu Carrinho</h1>

    @if($items->isEmpty())
        <p class="text-gray-400">De momento não há itens no seu carrinho, por favor adicione alguns para conseguir prosseguir ao pagamento.</p>
    @else

    <table class="w-full bg-gray-800 text-white rounded-lg">
        <thead>
            <tr>
                <th>Livro</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @php $total = 0; @endphp

            @foreach($items as $item)
                @php
                    $subtotal = $item->livro->Preco * $item->quantidade;
                    $total += $subtotal;
                @endphp

                <tr>
                    <td>{{ $item->livro->Nome_livro }}</td>
                    <td>{{ $item->livro->Preco }}€</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>{{ $subtotal }}€</td>

                    <td>
                        <form action="{{ route('carrinho.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 px-2 mb-2 py-1 rounded">
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-xl font-bold">
        Total: {{ $total }} €
    </div>

    <a href="{{ route('checkout.index') }}"
    class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
        Prosseguir ao pagamento
    </a>

    @endif

</x-layout>
