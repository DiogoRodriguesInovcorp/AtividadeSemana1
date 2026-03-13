<x-layout>

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-6">Resultados</h1>

    <div class="grid grid-cols-4 gap-6">

        @if($livros)

            @foreach($livros as $livro)

                <div class="bg-gray-800 p-4 rounded">

                    <img
                        src="{{ asset('storage/'.$livro->Imagem_da_capa) }}"
                        class="w-full h-48 object-cover mb-2"
                    >

                    <h2 class="font-bold">
                        {{ $livro->Nome_livro }}
                    </h2>

                    <p class="text-sm text-gray-400">
                        {{ $livro->autores->first()->Nome_autor ?? 'Autor desconhecido' }}
                    </p>

                    <p class="text-green-400 text-sm mt-2">
                        Já existe na biblioteca
                    </p>

                </div>

            @endforeach

        @endif


        @if($livrosApi)

            @foreach($livrosApi as $livro)

                @php
                    $info = $livro['volumeInfo'] ?? [];
                    $isbn = $info['industryIdentifiers'][0]['identifier'] ?? null;
                    $existe = \App\Models\Livro::where('ISBN', $isbn)->exists();
                @endphp

                <div class="bg-gray-800 p-4 rounded">

                    <img
                        src="{{ $info['imageLinks']['thumbnail'] ?? '' }}"
                        class="w-full h-48 object-cover mb-2"
                    >

                    <h2 class="font-bold">
                        {{ $info['title'] ?? 'Sem título' }}
                    </h2>

                    <p class="text-sm text-gray-400">
                        {{ $info['authors'][0] ?? 'Autor desconhecido' }}
                    </p>

                    @if($existe)

                        <p class="text-green-400 text-sm mt-2">
                            Já existe na biblioteca
                        </p>
                    @else

                        <form method="POST" action="{{ route('admin.guardar') }}">
                            @csrf

                            <input type="hidden" name="titulo" value="{{ $info['title'] ?? '' }}">
                            <input type="hidden" name="autor" value="{{ implode(',', $info['authors'] ?? []) }}">
                            <input type="hidden" name="descricao" value="{{ $info['description'] ?? '' }}">
                            <input type="hidden" name="capa" value="{{ $info['imageLinks']['thumbnail'] ?? '' }}">
                            <input type="hidden" name="isbn" value="{{ $info['industryIdentifiers'][0]['identifier'] ?? '' }}">
                            <input type="hidden" name="editora" value="{{ $info['publisher'] ?? 'Desconhecida' }}">
                            <input type="hidden" name="preco" value="{{ $livro['saleInfo']['listPrice']['amount'] ?? 0 }}">

                            <button class="btn btn-success mt-2 w-full">
                                Importar Livro
                            </button>

                        </form>
                    @endif
                </div>

            @endforeach

        @endif

    </div>

</x-layout>
