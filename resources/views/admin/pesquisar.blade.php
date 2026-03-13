<x-layout>

    <h1 class="text-2xl font-bold mb-4">Pesquisar Livros</h1>

    <form action="{{ route('admin.resultados') }}" method="GET">

        <input
            type="text"
            name="q"
            placeholder="Pesquisar livro..."
            class="input input-bordered w-full"
        />

        <button class="btn btn-primary mt-2">
            Pesquisar
        </button>

    </form>

</x-layout>
