<div class="navbar bg-base-200">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>
            <ul
                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a>Exportar livros</a></li>
                <li><a>Livros</a></li>
                <li><a>Autores</a></li>
                <li><a>Editoras</a></li>
                <li><a>As Minhas Requisições</a></li>
            </ul>
        </div>
        <a href="/index" class="btn btn-ghost text-xl">Biblioteca - Menu</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li><a class="bg-green-700 text-white rounded-xl shadow hover:bg-green-600 transition" href="/livros/exportar">
                    Exportar lista -->
                </a></li>
            <li><a class=" bg-orange-500 text-white rounded-xl shadow hover:bg-orange-400 transition" href="/livros">Livros</a></li>
            <li><a class=" bg-orange-500 text-white rounded-xl shadow hover:bg-orange-400 transition" href="/autores">Autores</a></li>
            <li><a class=" bg-orange-500 text-white rounded-xl shadow hover:bg-orange-400 transition" href="/editoras">Editoras</a></li>
        </ul>
    </div>
    <div class="navbar-end space-x-2">
                @guest
                    <a class="btn btn-warning" href="/escolher-registo">Registar</a>
                    <a class="btn btn-success" href="/escolher-login">Entrar</a>
                @endguest

                @auth
                    <div class="dropdown dropdown-end font-bold">

                        <div tabindex="0" role="button" class="btn btn-ghost text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />

                            </svg>
                        </div>

                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-56 p-2 shadow">

                            <li>
                                <a href="/perfil">Perfil</a>
                            </li>

                            <li>
                                <a href="/requisicoes">As Minhas Requisições</a>
                            </li>

                            <li>
                                <a href="/Pagamento_livros/carrinho">
                                     Ver Carrinho
                                </a>
                            </li>

                            @can('Admin_ver')

                                <li>
                                    <a href="/requisicoes-todas">
                                        Todas as Requisições
                                    </a>
                                </li>

                                <li>
                                    <a href="/admin/encomendas">
                                        Gerir Encomendas
                                    </a>
                                </li>

                                <li>
                                    <a href="/criar">
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <a href="/criar-admin">
                                        Criar Novo Admin
                                    </a>
                                </li>

                                <li>
                                    <a href="/admin/pesquisar">
                                        Pesquisar livros
                                    </a>
                                </li>

                                <li>
                                    <a href="/admin/reviews">
                                        Ver Reviews
                                    </a>

                                </li>

                            @endcan

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left">
                                        Sair
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </div>
                @endauth
    </div>
</div>
