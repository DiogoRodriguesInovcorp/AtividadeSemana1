<x-layout>

<h1 class="text-3xl font-bold mb-6">Checkout</h1>

<table class="w-full bg-gray-800 text-white rounded-lg mb-6">
    <thead>
        <tr>
            <th>Livro</th>
            <th>Preço</th>
            <th>Qtd</th>
        </tr>
    </thead>

    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->livro->Nome_livro }}</td>
                <td>{{ $item->livro->Preco }}€</td>
                <td>{{ $item->quantidade }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-xl font-bold mb-6">
    Total: {{ $total }} €
</div>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf

    <input name="morada"
           placeholder="Morada de entrega"
           class="text-white bg-gray-700 placeholder:text-gray-400 px-4 py-2 rounded w-full mb-4"
           required>

    <button class="bg-green-600 px-6 py-3 rounded text-white">
        Continuar
    </button>
</form>

</x-layout>
