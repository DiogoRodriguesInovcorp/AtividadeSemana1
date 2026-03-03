<x-layout>

    <div class="max-w-6xl mx-auto flex gap-10 mt-10">

        <div class="w-1/3">
            <img
                src="{{ asset('storage/' . $livro->Imagem_da_capa) }}"
                class="rounded-2xl shadow-2xl"
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
                € {{ $livro->Preco }}
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
    </div>
</x-layout>
