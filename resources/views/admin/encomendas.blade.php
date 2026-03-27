<x-layout>

    <h1 class="text-3xl font-bold mb-6">Encomendas</h1>

    <table class="w-full bg-gray-800 text-white rounded-lg">
        <thead class="bg-gray-700">
            <tr>
                <th class="p-3">User</th>
                <th class="p-3">Total</th>
                <th class="p-3">Morada</th>
                <th class="p-3">Estado</th>
                <th class="p-3">Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($encomendas as $enc)
                <tr class="border-b border-gray-600">
                    <td class="p-3">{{ $enc->user->name }}</td>
                    <td class="p-3">{{ $enc->total }} €</td>
                    <td class="p-3">{{ $enc->morada }}</td>
                    <td class="p-3">
                        @if($enc->estado == 'pago')
                            <span class="text-green-400">Pago</span>
                        @else
                            <span class="text-yellow-400">Pendente</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $enc->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
