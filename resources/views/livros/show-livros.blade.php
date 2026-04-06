<x-layout>
    <div id="alert" class="fixed top-5 right-5 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg z-50 opacity-0 translate-y-2 transition-all duration-500">
    {{ session('success') }}
    </div>

    <script>
        const alert = document.getElementById('alert');
        if(alert){
            setTimeout(() => {
                alert.classList.remove('opacity-0','translate-y-2');
            }, 100);

            setTimeout(() => {
                alert.classList.add('opacity-0','translate-y-2');
            }, 3000);
        }
    </script>

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
    <div class="mt-8 flex flex-wrap gap-3 mb-6 items-center">

        <a href="/livros"
        class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
            Ver Livros
        </a>

        <a href="/autores"
        class="px-6 py-3 bg-orange-500 text-white rounded-xl shadow hover:bg-orange-400 transition">
            Ver Autores
        </a>

        <form action="{{ route('carrinho.add', $livro->id) }}" method="POST">
            @csrf
            <button class="px-6 py-3 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                Adicionar ao Carrinho
            </button>
        </form>

        @if($livro->estaDisponivel())

            <form action="{{ route('requisicoes.store', $livro) }}" method="POST">
                @csrf
                <button class="px-6 py-3 bg-green-700 text-white rounded-xl shadow hover:bg-green-800">
                    Requisitar Livro
                </button>
            </form>

        @else

            <span class="bg-gray-600 text-white px-6 py-3 rounded-xl shadow">
                Livro indisponível
            </span>

            @php
                $jaNotificado = \App\Models\AlertasDisponibilidade::where('user_id', auth()->id())
                                ->where('livro_id', $livro->id)
                                ->exists();
            @endphp

            <form method="POST" action="{{ route('alerta.disponibilidade.store') }}">
                @csrf
                <input type="hidden" name="livro_id" value="{{ $livro->id }}">

                <button type="submit"
                    @if($jaNotificado) disabled @endif
                    class="px-6 py-3 rounded-xl text-white shadow
                    @if($jaNotificado)
                        bg-gray-600 cursor-not-allowed
                    @else
                        bg-green-800 hover:bg-yellow-400
                    @endif">
                    🔔 Notificar-me
                </button>
            </form>

        @endif

        @auth
            @if(auth()->user()->isAdmin())
                <form action="{{ route('livros.destroy', $livro) }}" method="POST"
                    onsubmit="return confirm('Tens a certeza que queres retirar este livro?')">
                    @csrf
                    @method('DELETE')

                    <button class="px-6 py-3 bg-red-600 hover:bg-red-800 text-white rounded-xl shadow transition">
                        Retirar Livro
                    </button>
                </form>
            @endif
            <script>
                function confirmarNotificacao() {
                    alert('Obrigado! Você receberá um email quando o livro estiver disponível.');
                    return true; // Continua com o envio do formulário
                }
            </script>
        @endauth
    </div>

    @if($livrosRelacionados->count())
        <h2 class="text-3xl font-bold mb-6">Livros Relacionados</h2>

        <div class="relative">

            <!-- Container scroll horizontal -->
            <div id="relacionados-container" class="flex overflow-x-auto gap-4 scrollbar-hide px-6 py-4">
                @foreach($livrosRelacionados as $rel)
                    <div class="min-w-50 bg-gray-800 p-4 rounded-xl shadow shrink-0 hover:scale-105 transition cursor-pointer"
                         onclick="window.location='{{ route('livros.show', $rel->id) }}'">
                        <img src="{{ Str::startsWith($rel->Imagem_da_capa,'http') ? $rel->Imagem_da_capa : asset('storage/'.$rel->Imagem_da_capa) }}"
                             class="w-full h-48 object-cover rounded-lg mb-2">
                        <h3 class="text-lg font-bold text-orange-400">{{ $rel->Nome_livro }}</h3>
                        <p class="text-gray-300 text-sm">
                            @foreach($rel->autores as $autor)
                                {{ $autor->Nome_autor }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        <p class="text-green-400 font-bold mt-1">{{ $rel->Preco }} €</p>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            const container = document.getElementById('relacionados-container');
            function scrollLeft() {
                container.scrollBy({ left: -250, behavior: 'smooth' });
            }
            function scrollRight() {
                container.scrollBy({ left: 250, behavior: 'smooth' });
            }
        </script>
    @endif

    <div>
        <h2 class="text-3xl py-8 font-bold mb-4">Reviews</h2>
        <div class="space-y-4">
            @forelse($reviews as $review)
                <div class="bg-gray-800 p-4 rounded-xl shadow transition">
                    <div class="flex items-center gap-4 mb-2">
                        <!-- Foto do usuário -->
                        <img src="{{ $review->user?->foto_user ? asset('storage/'.$review->user->foto_user) : asset('images/default-user.png') }}"
                             class="w-12 h-12 rounded-full object-cover">

                        <!-- Nome e estrelas -->
                        <div class="flex-1 flex flex-col">
                            <p class="text-white font-semibold">{{ $review->user->name }}</p>
                            <div class="flex gap-1 text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-500' }}">&#9733;</span>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Comentário -->
                    <p class="text-gray-200 mt-2">{{ $review->comentario }}</p>

                    <!-- Justificação (se recusado) -->
                    @if($review->estado == 'recusado' && $review->justificacao)
                        <p class="text-red-400 mt-2 font-medium">Justificação: {{ $review->justificacao }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400">Ainda não existem reviews para este livro.</p>
            @endforelse
        </div>
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

    <div class="mt-8 flex justify-center items-center gap-3     ">
        @if($historico->currentPage() > 1)
            <a href="{{ $historico->url(1) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                &laquo; Primeira
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">&laquo; Primeira</span>
        @endif

        @if($historico->onFirstPage())
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $historico->previousPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Anterior</a>
        @endif

        @foreach(range(1, $historico->lastPage()) as $page)
            @if($page == $historico->currentPage())
                <span class="px-4 py-2 bg-orange-600 text-white rounded">{{ $page }}</span>
            @else
                <a href="{{ $historico->url($page) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">{{ $page }}</a>
            @endif
        @endforeach

        @if($historico->hasMorePages())
            <a href="{{ $historico->nextPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Próximo</a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Próximo</span>
        @endif

        @if($historico->currentPage() < $historico->lastPage())
            <a href="{{ $historico->url($historico->lastPage()) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                Última &raquo;
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Última &raquo;</span>
        @endif
    </div>
</x-layout>
