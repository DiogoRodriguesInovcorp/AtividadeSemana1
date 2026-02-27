<x-layout>

    <h1 class="w-full text-center text-5xl md:text-7xl font-bold text-amber-900 py-10">
        Caro/a Bibliotecário/a
    </h1>
    <h2 class="text-center font-bold text-amber-100">Bem-vindo ao lugar privado da biblioteca,
        onde pode colocar livros, autores e editoras, é só prosseguir pelos próximos passos.
    </h2>

    <form action="/criar" method="POST" class="flex items-center justify-center py-20">
        @csrf


        <div class="carousel w-full max-w-3xl gap-6">
            <div id="slide1" class="carousel-item relative w-full flex justify-center">

                <div class="card bg-neutral text-neutral-content w-full h-96 shadow-2xl">
                    <div class="card-body items-center text-center justify-center">
                        <h2 class="card-title text-3xl py-15">Livros</h2>
                        <p class="text-lg">Carregue em "Visitar" para colocar um livro na biblioteca!</p>
                        <div class="card-actions justify-end py-10">
                            <a class="btn btn-soft-warning" href="/criar-livros">Visitar</a>
                        </div>
                    </div>
                </div>

                <div class="absolute right-5 top-1/2 flex -translate-y-1/2 transform">
                    <a href="#slide2" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide2" class="carousel-item relative w-full flex justify-center">

                <div class="card bg-neutral text-neutral-content w-full h-96 shadow-2xl">
                    <div class="card-body items-center text-center justify-center">
                        <h2 class="card-title text-3xl py-15">Autores</h2>
                        <p class="text-lg">Carregue em "Visitar" para colocar um autor/a na biblioteca!</p>
                        <div class="card-actions justify-end py-10">
                            <a class="btn btn-soft-warning" href="/criar-autores">Visitar</a>
                        </div>
                    </div>
                </div>

                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide1" class="btn btn-circle">❮</a>
                    <a href="#slide3" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide3" class="carousel-item relative w-full flex justify-center">

                <div class="card bg-neutral text-neutral-content w-full h-96 shadow-2xl">
                    <div class="card-body items-center text-center justify-center">
                        <h2 class="card-title text-3xl py-15">Editoras</h2>
                        <p class="text-lg">Carregue em "Visitar" para colocar uma Editora na biblioteca!</p>
                        <div class="card-actions justify-end py-10">
                            <a class="btn btn-soft-warning" href="/criar-editoras">Visitar</a>
                        </div>
                    </div>
                </div>

                <div class="absolute left-5 top-1/2 flex -translate-y-1/2 transform">
                    <a href="#slide2" class="btn btn-circle">❮</a>
                </div>
            </div>
        </div>
    </form>
</x-layout>
