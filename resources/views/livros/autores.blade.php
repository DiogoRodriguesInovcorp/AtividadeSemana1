<x-layout>
    <div class="max-w-6xl mx-auto mt-10">

        <form method="GET" class="flex gap-4 mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Procurar autor..."
                   class="px-3 py-2 rounded border w-1/3">
            <select name="sort" class="px-3 py-2 rounded border">
                <option value="">Ordenar por</option>
                <option value="Nome_autor" {{ request('sort')=='Nome_autor' ? 'selected':'' }}>Nome</option>
                <option value="created_at" {{ request('sort')=='created_at' ? 'selected':'' }}>Data</option>
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
                <th class="px-10 py-6 text-lg font-bold">Autor/a</th>
            </tr>
            </thead>
            <tbody>
            @foreach($autores as $autor)
                <tr onclick="window.location='{{ route('autores.show', $autor->id) }}'"
                    class="border-b border-gray-600 cursor-pointer hover:bg-gray-700 transition">
                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $autor->Foto_autor) }}" class="w-12 h-12 rounded-full object-cover">
                        <span>{{ $autor->Nome_autor }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div class="mt-8 flex justify-center items-center gap-3">
        @if($autores->currentPage() > 1)
            <a href="{{ $autores->url(1) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                &laquo; Primeira
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">&laquo; Primeira</span>
        @endif

        @if($autores->onFirstPage())
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $autores->previousPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Anterior</a>
        @endif

        @foreach(range(1, $autores->lastPage()) as $page)
            @if($page == $autores->currentPage())
                <span class="px-4 py-2 bg-orange-600 text-white rounded">{{ $page }}</span>
            @else
                <a href="{{ $autores->url($page) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">{{ $page }}</a>
            @endif
        @endforeach

        @if($autores->hasMorePages())
            <a href="{{ $autores->nextPageUrl() }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">Próximo</a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Próximo</span>
        @endif

        @if($autores->currentPage() < $autores->lastPage())
            <a href="{{ $autores->url($autores->lastPage()) }}" class="px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-500 transition">
                Última &raquo;
            </a>
        @else
            <span class="px-4 py-2 bg-gray-600 text-white rounded cursor-not-allowed">Última &raquo;</span>
        @endif
    </div>
</x-layout>
