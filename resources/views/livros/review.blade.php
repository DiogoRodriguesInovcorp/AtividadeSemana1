<x-layout>

    <h1 class="text-2xl font-bold mb-6">
        A Sua Review - {{ $requisicao->livros->Nome_livro }}
    </h1>

    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf

        <input type="hidden" name="livro_id" value="{{ $requisicao->livro_id }}">
        <input type="hidden" name="requisicao_id" value="{{ $requisicao->id }}">

        <input type="hidden" name="rating" id="rating-value" required>

        <!-- 💬 COMENTÁRIO -->
        <label class="block mb-2">Comentário:</label>

        <textarea name="comentario"
                  class="w-full p-2 text-white bg-gray-500 rounded"
                  required></textarea>

        <!-- ⭐ RATING -->
        <label class="block mb-2">Avaliação:</label>

        <div class="flex gap-2 mb-4" id="star-rating">
            @for($i = 1; $i <= 5; $i++)
                <span class="star text-gray-400 text-3xl cursor-pointer" data-value="{{ $i }}">&#9733;</span>
            @endfor
        </div>


        <button class="bg-green-700 text-white px-4 py-2 mt-4 rounded">
            Submeter Review
        </button>
    </form>

    <script>
        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating-value');
        let currentRating = 0;

        stars.forEach(star => {
            // Hover
            star.addEventListener('mouseover', () => {
                const val = parseInt(star.dataset.value);
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < val);
                });
            });

            // Mouseout - volta ao valor selecionado
            star.addEventListener('mouseout', () => {
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < currentRating);
                });
            });

            // Clique
            star.addEventListener('click', () => {
                currentRating = parseInt(star.dataset.value);
                ratingInput.value = currentRating;
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < currentRating);
                });
            });
        });
    </script>

</x-layout>
