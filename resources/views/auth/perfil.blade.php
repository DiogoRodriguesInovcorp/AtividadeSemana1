<x-layout>

    <div class="max-w-5xl mx-auto mt-10">

        <div class="max-w-4xl mx-auto mt-10">

            <h1 class="text-3xl font-bold mb-6">
                Meu Perfil
            </h1>

            <div class="grid grid-cols-2 gap-10">

                <div>

                    <form action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <img
                            id="preview"
                            src="{{ $user->foto_user ? asset('storage/'.$user->foto_user) : '' }}"
                            class="w-40 h-40 rounded-full object-cover bg-gray-300"
                        >

                        <input type="file" class="file-input file-input-bordered w-full text-white mt-3" name="foto_user" onchange="previewFoto(event)">

                        <button class="btn btn-primary mt-2">
                            Atualizar Foto
                        </button>

                    </form>

                </div>


                <div>

                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf

                        <label class="label">Nome</label>
                        <input type="text" name="name"
                               value="{{ $user->name }}"
                               class="input input-bordered w-full mb-4">

                        <label class="label">Email</label>
                        <input type="email" name="email"
                               value="{{ $user->email }}"
                               class="input input-bordered w-full mb-4">

                        <button class="btn btn-success">
                            Atualizar Perfil
                        </button>

                    </form>


                    <hr class="my-6">

                    <form action="{{ route('perfil.password') }}" method="POST">
                        @csrf

                        <label class="label">Nova Password</label>
                        <input type="password"
                               name="password"
                               class="input input-bordered w-full mb-3">

                        <label class="label">Confirmar Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="input input-bordered w-full mb-4">

                        <button class="btn btn-warning">
                            Alterar Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

            <h2 class="text-2xl font-bold mb-4">O Meu Histórico de Requisições</h2>

        <table class="table-auto w-full bg-gray-800 text-white rounded-lg overflow-hidden">

            <thead class="bg-gray-700">
            <tr>
                <th class="px-4 py-2">Livro</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Data</th>
            </tr>
            </thead>

            <tbody>

            @foreach(auth()->user()->requisicoes as $r)

                <tr class="border-t border-gray-700">
                    <td class="px-4 py-2">{{ $r->livros->Nome_livro ?? 'Livro removido' }}</td>
                    <td class="px-4 py-2">{{ $r->estado }}</td>
                    <td class="px-4 py-2">{{ $r->data_requisicao }}</td>
                </tr>

            @endforeach

            </tbody>

        </table>

    </div>
        <script>
            function previewFoto(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    document.getElementById('preview').src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }

             filterLivro = document.getElementById('filter-livro');
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

    <div class="mt-8 flex justify-center items-center gap-3">
        @if($requisicoes->currentPage() > 1)
            <a href="{{ $requisicoes->url(1) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                &laquo; Primeira
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">&laquo; Primeira</span>
        @endif

        @if($requisicoes->onFirstPage())
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $requisicoes->previousPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Anterior</a>
        @endif

        @foreach(range(1, $requisicoes->lastPage()) as $page)
            @if($page == $requisicoes->currentPage())
                <span class="px-4 py-2 bg-orange-600 text-white rounded">{{ $page }}</span>
            @else
                <a href="{{ $requisicoes->url($page) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">{{ $page }}</a>
            @endif
        @endforeach

        @if($requisicoes->hasMorePages())
            <a href="{{ $requisicoes->nextPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Próximo</a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Próximo</span>
        @endif

        @if($requisicoes->currentPage() < $requisicoes->lastPage())
            <a href="{{ $requisicoes->url($requisicoes->lastPage()) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                Última &raquo;
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Última &raquo;</span>
        @endif
    </div>
</x-layout>
