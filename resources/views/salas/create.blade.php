<x-layout title="Criar Sala">

    <div class="max-w-md mx-auto bg-gray-900 p-6 rounded-xl shadow">

        <h2 class="text-xl text-white font-bold mb-4">Criar Sala</h2>

        <form method="POST" action="{{ route('salas.store') }}">
            @csrf

            <input type="text" name="nome"
                class="w-full border text-white p-2 rounded mb-4"
                placeholder="Nome da sala">

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Criar
            </button>
        </form>

    </div>

</x-layout>
