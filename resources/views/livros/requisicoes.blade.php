<x-layout>
    <h1 class="text-3xl py-12 font-bold mb-3">As Minhas Requisições</h1>

    <div class="overflow-x-auto">


        <table class="table-auto w-full mt-6 bg-gray-800 text-white rounded-lg overflow-hidden">
            <thead class="bg-gray-700 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Código do Livro</th>
                <th class="px-6 py-3">Nome do Livro</th>
                <th class="px-6 py-3">Estado</th>
                <th class="px-6 py-3">Data da Requisição</th>
                <th class="px-6 py-3">Data de Entrega Prevista</th>
            </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
            @foreach($requisicoes as $r)
                <tr>
                    <td class="px-6 py-4">ID: {{ $r->codigo }}</td>
                    <td class="px-6 py-4">{{ $r->livros->Nome_livro}}</td>
                    <td class="px-6 py-4">{{ $r->estado }}</td>
                    <td class="px-6 py-4">{{ $r->data_requisicao->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $r->data_prevista_entrega->format('d/m/Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-layout>
