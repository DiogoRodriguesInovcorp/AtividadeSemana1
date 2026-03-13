<x-layout>

    <div class="max-w-6xl mx-auto flex gap-10 mt-10">

        <div class="w-1/3">
            <img
                src="{{ Str::startsWith($livro->Imagem_da_capa, 'http')
                ? $livro->Imagem_da_capa
                : asset('storage/'.$livro->Imagem_da_capa) }}"
                class="rounded-2xl shadow-2xl w-48"
            />
        </div>

        <div class="w-2/3">

            <h1 class="text-4xl font-bold text-orange-400">
                {{ $livro->Nome_livro }}
            </h1>

            <div class="mt-4 text-gray-300">
                <strong>Autores:</strong>
                @foreach($livro->autores as $autor)
                    {{ $autor->Nome_autor }}@if(!$loop->last), @endif
                @endforeach
            </div>

            <div class="mt-2 text-gray-300">
                <strong>Editora:</strong>
                {{ $livro->editoras->Nome_editora }}
            </div>

            <div class="mt-2 text-gray-300">
                <strong>ISBN:</strong>
                {{ $livro->ISBN }}
            </div>

            <div class="mt-6 text-gray-300">
                {{ $livro->Bibliografia }}
            </div>

            <div class="mt-6 text-2xl font-bold text-green-400">
                {{ $livro->Preco }} €
            </div>



        </div>

    </div>
    <div class="mt-8">
        <a href="/livros"
           class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
            Ver Livros
        </a>
        ­
        <a href="/autores"
           class="px-6 py-3 bg-orange-500 text-white rounded-xl shadow hover:bg-orange-400 transition">
            Ver Autores
        </a>
        ­
        @auth
            @if(auth()->user()->isAdmin())
                <form action="{{ route('livros.destroy', $livro) }}" method="POST"
                      class="inline-block"
                      onsubmit="return confirm('Tens a certeza que queres retirar este livro?')">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 hover:bg-red-800 text-white px-6 py-3  rounded-xl shadow transition">
                        Retirar Livro
                    </button>
                </form>
            @endif
        @endauth
            @if($livro->estaDisponivel())
                <form action="{{ route('requisicoes.store', $livro) }}" method="POST"
                      class="inline-block">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white rounded-xl shadow hover:bg-green-800">
                        Requisitar Livro
                    </button>

                </form>
                @if(session('error'))
                <div class="text-red-500 font-bold mt-6">
                    {{ session('error') }}
                </div>
                @endif
            @else
                <span class="bg-gray-600 text-white px-6 py-3 cursor-not-allowed rounded-xl shadow transition">Livro indisponível</span>
            @endif
    </div>



    <h3 class="text-3xl py-8 font-bold mb-3">Histórico de Requisições do Livro</h3>

    <div class="overflow-x-auto">
        <div class="overflow-y-auto mb-6">
            <input type="text" id="filter-usuario" placeholder="Filtrar por utilizador..."
                   class="px-3 py-2 rounded text-white bg-gray-600">
            <select id="filter-estado" class="px-3 py-2 rounded text-white bg-gray-600">
                <option value="">Todos os estados</option>
                <option value="ativa">Ativa</option>
                <option value="devolvido">Devolvido</option>
            </select>
        </div>

        <table class="table-auto w-full bg-gray-800 text-white rounded-lg overflow-hidden">
            <thead class="bg-gray-700 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Foto do Responsável</th>
                    <th class="px-6 py-3">Código do Livro</th>
                    <th class="px-6 py-3">Nome do Responsável</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Data da Requisição</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($historico as $h)
                    <tr>
                        <td class="px-6 py-4">
                            <img
                                src="{{ $h->user?->foto_user ? asset('storage/'.$h->user->foto_user) : asset('images/default-user.png') }}"
                                class="w-10 h-10 rounded-full object-cover"
                            >
                        </td>
                        <td class="px-6 py-4">ID: {{ $h->codigo }}</td>
                        <td  class="px-6 py-4">{{ $h->user?->name ?? 'Utilizador removido' }}</td>
                        <td class="px-6 py-4">{{ $h->estado }}</td>
                        <td class="px-6 py-4">{{ $h->data_requisicao->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        const filterUsuario = document.getElementById('filter-usuario');
        const filterEstado = document.getElementById('filter-estado');
        const rows = document.querySelectorAll('tbody tr');

        filterUsuario.addEventListener('input', filterTable);
        filterEstado.addEventListener('change', filterTable);

        function filterTable() {
            const usuarioValue = filterUsuario.value.toLowerCase();
            const estadoValue = filterEstado.value.toLowerCase();

            rows.forEach(row => {

                const usuarioText = row.children[2].textContent.toLowerCase();
                const estadoText = row.children[3].textContent.toLowerCase();

                const matchesUsuario = usuarioText.includes(usuarioValue);
                const matchesEstado = estadoValue === '' || estadoText === estadoValue;

                row.style.display = (matchesUsuario && matchesEstado) ? '' : 'none';

            });
        }
    </script>
</x-layout>
