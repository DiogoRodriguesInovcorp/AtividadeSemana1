<x-layout>

    <h1 class="text-2xl mb-6">Reviews</h1>

    <form method="GET" class="flex gap-4 mb-4">

        <select name="estado" class="px-3 py-2 rounded border">
            <option value="">Todos os estados</option>
            <option value="suspenso" {{ request('estado')=='suspenso' ? 'selected':'' }}>Suspenso</option>
            <option value="ativo" {{ request('estado')=='ativo' ? 'selected':'' }}>Ativo</option>
            <option value="recusado" {{ request('estado')=='recusado' ? 'selected':'' }}>Recusado</option>
        </select>

        <select name="sort" class="px-3 py-2 rounded border">
            <option value="">Ordenar por</option>
            <option value="created_at" {{ request('sort')=='created_at' ? 'selected':'' }}>Data</option>
            <option value="rating" {{ request('sort')=='rating' ? 'selected':'' }}>Avaliação</option>
        </select>

        <select name="direction" class="px-3 py-2 rounded border">
            <option value="asc" {{ request('direction')=='asc' ? 'selected':'' }}>Ascendente</option>
            <option value="desc" {{ request('direction')=='desc' ? 'selected':'' }}>Descendente</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500">Pesquisar</button>
    </form>

    <table class="table-auto w-full bg-gray-800 text-white rounded-lg overflow-hidden">
        <thead>
        <tr class="bg-gray-700">
            <th class="px-10 py-6 text-lg font-bold w-64">Livro</th>
            <th class="px-10 py-6 text-lg font-bold w-48">Responsável</th>
            <th class="px-10 py-6 text-lg font-bold w-32">Comentário</th>
            <th class="px-10 py-6 text-lg font-bold w-32">Avaliação</th>
            <th class="px-10 py-6 text-lg font-bold w-32">Estado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reviews as $review)
            <tr onclick="window.location='{{ route('reviews.show', $review->id) }}'"
                class="border-b border-gray-600 cursor-pointer hover:bg-gray-700 transition">
                <td class="px-6 py-4 text-lg">{{ $review->livro->Nome_livro }}</td>
                <td class="px-6 py-4 text-lg">{{ $review->user->name }}</td>
                <td class="px-6 py-4 text-lg">
                    {{ Str::limit($review->comentario, 50) }}
                </td>
                <td class="px-6 py-20 text-lg flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-400' }}">&#9733;</span>
                    @endfor
                </td>
                <td class="px-6 py-4 text-lg">
                    @if($review->estado == 'ativo')
                        <span class="text-green-600 font-bold">Ativo</span>
                    @elseif($review->estado == 'recusado')
                        <span class="text-red-600 font-bold">Recusado</span>
                        <div class="bottom-1 right-1">
                            <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded shadow text-sm"
                                        onclick="return confirm('Tem certeza que quer remover esta review?')">
                                    Remover
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-gray-400 font-bold">Suspenso</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        // Seleciona os filtros e as linhas da tabela
        const filterEstado = document.querySelector('select[name="estado"]');
        const filterSort = document.querySelector('select[name="sort"]'); // opcional se quiser ordenar client-side
        const filterDirection = document.querySelector('select[name="direction"]'); // opcional

        const tableRows = document.querySelectorAll('tbody tr');

        // Função de filtro
        function filterTable() {
            const estadoValue = filterEstado.value.toLowerCase();

            tableRows.forEach(row => {
                // pega o estado da célula da review
                const estadoText = row.children[4].textContent.toLowerCase(); // coluna Estado

                const matchesEstado = estadoValue === '' || estadoText.includes(estadoValue);

                row.style.display = matchesEstado ? '' : 'none';
            });
        }

        // Escuta mudanças
        filterEstado.addEventListener('change', filterTable);
    </script>

</x-layout>
