<x-layout>
    <div class="max-w-6xl mx-auto mt-10 relative">

        <div class="relative flex items-center gap-6 mb-8">
            <img src="{{ asset('storage/' . $autor->Foto_autor) }}"
                 class="flex  top-0 left-0 w-30 h-32 rounded-full object-cover -z-10">
            <h1 class="text-5xl font-bold text-orange-400 ml-12">
                {{ $autor->Nome_autor }}
            </h1>
        </div>

        <div class="text-gray-300 mb-6">
            <strong>Total de livros:</strong> {{ $livros->count() }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($livros as $livro)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg cursor-pointer hover:shadow-xl transition"
                     onclick="window.location='{{ route('livros.show', $livro->id) }}'">
                    <img src="{{ asset('storage/' . $livro->Imagem_da_capa) }}" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-orange-400">{{ $livro->Nome_livro }}</h2>
                        <p class="text-gray-300 mt-2">€ {{ $livro->Preco }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="/autores"
               class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
                Ver Autores
            </a>
        </div>
    </div>
</x-layout>
