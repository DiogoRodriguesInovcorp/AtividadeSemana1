<x-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <!-- Cabeçalho -->
        <h1 class="text-3xl font-bold mb-8 text-center text-orange-400">Detalhe da Review</h1>

        <!-- Card da Review -->
        <div class="bg-gray-900 shadow-lg rounded-2xl p-8 space-y-6 border border-gray-700">

            <!-- Livro e usuário -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <p class="text-gray-400 font-semibold">Livro:</p>
                    <p class="text-white text-lg font-medium">{{ $livro->Nome_livro }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-semibold">Usuário:</p>
                    <p class="text-white text-lg font-medium">{{ $review->user->name }}</p>
                </div>
            </div>

            <!-- Comentário -->
            <div>
                <p class="text-gray-400 font-semibold mb-1">Comentário:</p>
                <p class="bg-gray-800 p-4 rounded-lg text-white">{{ $review->comentario }}</p>
            </div>

            <!-- Avaliação por estrelas -->
            <div>
                <p class="text-gray-400 font-semibold mb-1">Avaliação:</p>
                <div class="flex gap-1 text-3xl">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-500' }}">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Estado -->
            <div>
                <p class="text-gray-400 font-semibold mb-1">Estado:</p>
                <span class="px-3 py-1 rounded-full font-semibold
                    {{ $review->estado == 'ativo' ? 'bg-green-700 text-green-100' : ($review->estado=='recusado' ? 'bg-red-700 text-red-100' : 'bg-gray-600 text-gray-100') }}">
                    {{ ucfirst($review->estado) }}
                </span>
            </div>

            <!-- Justificação, se recusado -->
            @if($review->estado == 'recusado' && $review->justificacao)
                <div>
                    <p class="text-gray-400 font-semibold mb-1">Justificação:</p>
                    <p class="bg-gray-800 p-4 rounded-lg text-red-300">{{ $review->justificacao }}</p>
                </div>
            @endif

            <!-- Formulário para admin -->
            @if(Auth::user()->isAdmin())
                <form method="POST" action="{{ route('reviews.update', $review->id) }}" class="mt-6 space-y-4 bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-inner">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-col md:flex-row md:items-center md:gap-6">
                        <label class="flex-1 text-white font-medium">
                            Estado:
                            <select name="estado" class="ml-2 px-3 py-2 bg-gray-700 text-white rounded-lg">
                                <option value="ativo" {{ $review->estado=='ativo'?'selected':'' }}>Ativar</option>
                                <option value="recusado" {{ $review->estado=='recusado'?'selected':'' }}>Recusar</option>
                            </select>
                        </label>
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-1">Justificação (se recusado):</label>
                        <textarea name="justificacao" class="w-full p-3 rounded-lg bg-gray-700 text-white" rows="3">{{ $review->justificacao }}</textarea>
                    </div>

                    <button class="bg-orange-500 hover:bg-orange-400 transition text-white font-semibold px-6 py-2 rounded-full">
                        Guardar
                    </button>
                </form>
            @endif

        </div>
    </div>
</x-layout>
