<x-layout>

    <h1 class="text-3xl py-8 font-bold mb-6">Todas as Requisições</h1>

    <div class="flex gap-6 mb-6">
        <div class="p-4 bg-blue-500 text-white rounded">
            Ativas: {{ $indicadores['ativas'] }}
        </div>
        <div class="p-4 bg-green-500 text-white rounded">
            Últimos 30 dias: {{ $indicadores['ultimos_30_dias'] }}
        </div>
        <div class="p-4 bg-yellow-500 text-white rounded">
            Entregues hoje: {{ $indicadores['entregues_hoje'] }}
        </div>
    </div>

    <div class="flex gap-4 mb-4">
        <input type="text" id="filter-livro" placeholder="Filtrar por livro..."
               class="px-3 py-2 rounded text-white bg-gray-600">
        <input type="text" id="filter-usuario" placeholder="Filtrar por utilizador..."
               class="px-3 py-2 rounded text-white bg-gray-600">
        <select id="filter-estado" class="px-3 py-2 rounded text-white bg-gray-600">
            <option value="">Todos os estados</option>
            <option value="ativa">Ativa</option>
            <option value="devolvido">Devolvido</option>
        </select>
    </div>

    <div class="overflow-x-auto mt-7">
        <div class="max-h-[500px] overflow-y-auto">
            <table class="table-auto w-full bg-gray-800 text-white rounded-lg">
                <thead class="bg-gray-700 text-white uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Código do Livro</th>
                        <th class="px-5 py-3">Nome do livro</th>
                        <th class="px-5 py-3">Foto do Responsável</th>
                        <th class="px-5 py-3">Nome do Responsável</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3">Data da Requisição</th>
                        <th class="px-5 py-3">Data da Entrega Prevista</th>
                    </tr>
            </thead>

                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($requisicoes as $r)
                        <tr>
                            <td class="px-2 py-2">ID: {{ $r->codigo }}</td>
                            <td class="px-2 py-2">{{ $r->livros->Nome_livro }}</td>
                            <td class="px-2 py-2">
                                <img
                                    src="{{ $r->user->foto_user ? asset('storage/'.$r->user->foto_user) : '' }}"
                                    class="w-8 h-8 rounded-full object-cover"
                                >
                            </td>
                            <td class="px-2 py-2">{{ $r->user->name }}</td>
                            <td class="px-2 py-2">{{ $r->estado }}</td>
                            <td class="px-2 py-2">{{ $r->data_requisicao->format('d/m/Y') }}</td>
                            <td class="px-2 py-2">{{ $r->data_prevista_entrega->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const filterLivro = document.getElementById('filter-livro');
        const filterUsuario = document.getElementById('filter-usuario');
        const filterEstado = document.getElementById('filter-estado');
        const rows = document.querySelectorAll('tbody tr');

        filterLivro.addEventListener('input', filterTable);
        filterUsuario.addEventListener('input', filterTable);
        filterEstado.addEventListener('change', filterTable);

        function filterTable() {
            const livroValue = filterLivro.value.toLowerCase();
            const usuarioValue = filterUsuario.value.toLowerCase();
            const estadoValue = filterEstado.value;

            rows.forEach(row => {
                const livroText = row.children[1].textContent.toLowerCase();
                const usuarioText = row.children[3].textContent.toLowerCase();
                const estadoText = row.children[4].textContent.toLowerCase();

                const matchesLivro = livroText.includes(livroValue);
                const matchesUsuario = usuarioText.includes(usuarioValue);
                const matchesEstado = estadoValue === '' || estadoText === estadoValue;

                row.style.display = (matchesLivro && matchesUsuario && matchesEstado) ? '' : 'none';
            });
        }
    </script>
</x-layout>
