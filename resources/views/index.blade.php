<x-layout>
    <div class="min-h-screen flex flex-col items-center justify-center">

        <div class="text-center mb-16">
            <h1 class="text-6xl md:text-7xl font-extrabold text-orange-400 tracking-wide mb-6">
                Biblioteca
            </h1>

            <p class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto">
                Bem-vindo à nossa biblioteca digital.
                Explora livros, descobre autores incríveis
                e conhece as editoras que dão vida às histórias.
            </p>
            <p class="mt-3 text-gray-200 text-lg md:text-xl max-w-2xl mx-auto">
                Para mais informações, clique num dos butões abaixo.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl w-full px-6 py-30">

            <div class="bg-gray-800 rounded-2xl shadow-xl p-10 text-center hover:scale-105 transition duration-300">
                <h2 class="text-3xl font-bold text-orange-400 mb-6">Livros</h2>
                <p class="text-white mb-8">
                    Explora todos os livros disponíveis no catálogo.
                </p>
                <a href="/livros"
                   class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
                    Ver Livros
                </a>
            </div>

            <div class="bg-gray-800 rounded-2xl shadow-xl p-10 text-center hover:scale-105 transition duration-300">
                <h2 class="text-3xl font-bold text-orange-400 mb-6">Autores</h2>
                <p class="text-white mb-8">
                    Descobre os autores e as suas obras.
                </p>
                <a href="/autores"
                   class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
                    Ver Autores
                </a>
            </div>

            <div class="bg-gray-800 rounded-2xl shadow-xl p-10 text-center hover:scale-105 transition duration-300">
                <h2 class="text-3xl font-bold text-orange-400 mb-6">Editoras</h2>
                <p class="text-white mb-8">
                    Conhece as editoras que publicam os livros.
                </p>
                <a href="/editoras"
                   class="px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
                    Ver Editoras
                </a>
            </div>

        </div>

    </div>
</x-layout>
