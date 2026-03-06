<x-layout>
    <h1 class="text-3xl py-12 font-bold mb-3">As Minhas Requisições</h1>

    <div class="mb-4 flex gap-4">
        <input type="text" id="filter-livro" placeholder="Filtrar por livro..."
               class="px-3 py-2 rounded text-white bg-gray-600">
        <select id="filter-estado" class="px-3 py-2 rounded text-white bg-gray-600">
            <option value="">Todos os estados</option>
            <option value="ativa">Ativa</option>
            <option value="devolvido">Devolvido</option>
        </select>
    </div>

    <div class="overflow-x-auto mt-6">
        <div class="max-h-[500px] overflow-y-auto">
            <table class="table-auto w-full bg-gray-800 text-white rounded-lg">
                <thead class="bg-gray-700 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Código do Livro</th>
                    <th class="px-6 py-3">Nome do Livro</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Data da Requisição</th>
                    <th class="px-6 py-3">Data de Entrega Prevista</th>
                    <th class="px-6 py-3">Ações</th>
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
                        <td class="px-6 py-4">
                            @if($r->estado == 'ativa')
                                <form method="POST" action="{{ url('/requisicoes/'.$r->id.'/devolver') }}">
                                    @csrf
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Fazer Devolução
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">Devolvido</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const filterLivro = document.getElementById('filter-livro');
        const filterEstado = document.getElementById('filter-estado');
        const rows = document.querySelectorAll('tbody tr');

        filterLivro.addEventListener('input', () => filterTable());
        filterEstado.addEventListener('change', () => filterTable());

        function filterTable() {
            const livroValue = filterLivro.value.toLowerCase();
            const estadoValue = filterEstado.value;

            rows.forEach(row => {
                const livroText = row.children[1].textContent.toLowerCase();
                const estadoText = row.children[2].textContent.toLowerCase();

                const matchesLivro = livroText.includes(livroValue);
                const matchesEstado = estadoValue === '' || estadoText === estadoValue;

                row.style.display = (matchesLivro && matchesEstado) ? '' : 'none';
            });
        }
    </script>

</x-layout>
