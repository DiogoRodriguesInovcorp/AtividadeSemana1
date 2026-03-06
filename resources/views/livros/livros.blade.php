<x-layout>
    <form method="GET" class="flex gap-4 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Procurar livro..." class="px-3 py-2 rounded border w-1/3">

        <select name="editora" class="px-3 py-2 rounded border">
            <option value="">Todas as editoras</option>
            @foreach($editoras as $editora)
                <option value="{{ $editora->id }}" {{ request('editora') == $editora->id ? 'selected' : '' }}>
                    {{ $editora->Nome_editora }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="px-3 py-2 rounded border">
            <option value="">Ordenar por</option>
            <option value="Nome_livro" {{ request('sort')=='Nome_livro' ? 'selected':'' }}>Nome</option>
            <option value="Preco" {{ request('sort')=='Preco' ? 'selected':'' }}>Preço</option>
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
            <th class="px-10 py-6 text-lg font-bold w-32">Capa</th>
            <th class="px-10 py-6 text-lg font-bold w-64">Nome</th>
            <th class="px-10 py-6 text-lg font-bold w-48">Autores</th>
            <th class="px-10 py-6 text-lg font-bold w-48">Editora</th>
            <th class="px-6 py-6 text-lg font-bold w-32">Preço</th>
            <th class="px-6 py-6 text-lg font-bold w-32">Estado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($livros as $livro)
            <tr onclick="window.location='{{ route('livros.show', $livro->id) }}'"
                class="border-b border-gray-600 cursor-pointer hover:bg-gray-700 transition">
                <td class="px-5 py-10">
                    <img src="{{ asset('storage/' . $livro->Imagem_da_capa) }}"
                         class="w-full h-auto object-cover rounded-lg">
                </td>
                <td class="px-6 py-4 text-lg">{{ $livro->Nome_livro }}</td>
                <td class="px-6 py-4 text-lg">
                    @foreach($livro->autores as $autor)
                        {{ $autor->Nome_autor }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td class="px-6 py-4 text-lg">{{ optional($livro->editoras)->Nome_editora ?? '-' }}</td>
                <td class="px-6 py-4 text-lg">{{ $livro->Preco }}€</td>
                <td class="px-6 py-4 text-lg">
                    @if($livro->estaDisponivel())
                        <span class="text-green-600 font-bold">Disponível</span>
                    @else
                        <span class="text-red-600 font-bold">Indisponível</span>
                   @endif
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="mt-8 flex justify-center items-center gap-3">
        @if($livros->currentPage() > 1)
            <a href="{{ $livros->url(1) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                &laquo; Primeira
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">&laquo; Primeira</span>
        @endif

        @if($livros->onFirstPage())
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $livros->previousPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Anterior</a>
        @endif

        @foreach(range(1, $livros->lastPage()) as $page)
            @if($page == $livros->currentPage())
                <span class="px-4 py-2 bg-orange-600 text-white rounded">{{ $page }}</span>
            @else
                <a href="{{ $livros->url($page) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">{{ $page }}</a>
            @endif
        @endforeach

        @if($livros->hasMorePages())
            <a href="{{ $livros->nextPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Próximo</a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Próximo</span>
        @endif

        @if($livros->currentPage() < $livros->lastPage())
            <a href="{{ $livros->url($livros->lastPage()) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                Última &raquo;
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Última &raquo;</span>
        @endif
    </div>
</x-layout>
