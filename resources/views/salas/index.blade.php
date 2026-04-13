<x-layout>

<div class="flex h-[80vh] bg-white rounded-xl shadow-lg overflow-hidden">

    <!-- SIDEBAR -->
    <div class="w-1/4 bg-gray-900 text-white flex flex-col">

        <div class="p-4 font-bold text-lg border-b border-gray-700">
            💬 Salas

            <div class="relative inline-block mx-6">
                <button onclick="toggleNotificacoes()" class="relative">
                    🔔

                    @if($notificacoesPendentes > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                            {{ $notificacoesPendentes }}
                        </span>
                    @endif
                </button>

                <div id="notificacoesBox"
                    class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">

                    <div class="bg-white w-[500px] max-h-[70vh] rounded-xl shadow-xl overflow-hidden flex flex-col">

                        <div class="p-4 border-b font-bold text-lg flex justify-between items-center">
                            🔔 Convites
                            <button onclick="toggleNotificacoes()" class="text-gray-500 hover:text-black">
                                ✖
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto p-4 space-y-3">
                            @forelse($convites as $convite)
                                <div class="border rounded-lg p-3 flex justify-between items-center bg-gray-50">
                                    <div>
                                        <div class="font-semibold">
                                            {{ $convite->sala->nome }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <div class="font-semibold">
                                                {{ $convite->sala->nome ?? 'Sala desconhecida' }}
                                            </div>

                                            <div class="text-sm text-gray-500">
                                                Convite para entrar neste grupo
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('convites.aceitar', $convite->id) }}">
                                            @csrf
                                            <button class="bg-green-500 text-white px-3 py-1 rounded">
                                                Aceitar
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('convites.recusar', $convite->id) }}">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded">
                                                Recusar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-10">
                                    Não tens convites pendentes
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">

            @auth
                @if(auth()->user()->permissao === 'admin')
                    <a href="{{ route('salas.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg w-full block text-center mb-4">
                        + Criar Sala
                    </a>
                @endif
            @endauth

        </div>

        <div class="flex-1 overflow-y-auto">
            @foreach($salas as $sala)
                <a href="{{ route('salas.index', ['sala_id' => $sala->id]) }}"
                   class="block px-4 py-3 hover:bg-gray-700 transition">

                   {{ $sala->nome }}
                </a>
            @endforeach
        </div>

    </div>

    <!-- CHAT AREA -->
    <div class="flex-1 flex flex-col bg-gray-200">

        <!-- MESSAGES -->
        @if($salaSelecionada)

            <!-- HEADER -->
            <div class="p-4 border-b font-semibold flex justify-between items-center relative">

                <span>{{ $salaSelecionada->nome }}</span>

                <button onclick="toggleInviteBox()"
                    class="text-blue-500 font-bold">
                    + Convidar
                </button>

                <div id="inviteBox"
                    class="hidden absolute right-10 top-16 bg-white text-black p-3 rounded shadow w-64 z-50">
                    <div class="font-bold mb-2">
                        Convidar utilizador
                    </div>
                    @foreach($users as $user)
                        <form method="POST" action="{{ route('salas.convidar', $salaSelecionada->id) }}" class="mb-1">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <button class="w-full text-left p-2 hover:bg-gray-100 rounded">
                                {{ $user->name }}
                            </button>
                        </form>
                    @endforeach
                </div>

                @auth
                    @if(auth()->user()->permissao === 'admin')
                        <button onclick="openDeleteModal()"
                            class="text-red-500 hover:text-red-700 font-bold">
                            🗑
                        </button>
                    @endif
                @endauth

            </div>

            <!-- MENSAGENS -->
            <div class="flex-1 overflow-y-auto p-4 space-y-2">
                @foreach($mensagens as $msg)
                    <div class="bg-white p-2 rounded shadow flex items-start gap-2">
                     <img src="{{ $msg->user?->foto_user ? asset('storage/'.$msg->user->foto_user) : asset('images/default-user.png') }}"
                        class="w-8 h-8 rounded-full">
                    <div>
                        <strong>{{ $msg->user->name }}</strong><br>
                        {{ $msg->mensagem }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- INPUT -->
            <form method="POST" action="{{ route('mensagens.store') }}" class="p-4 border-t flex gap-2">
                @csrf
                <input type="hidden" name="sala_id" value="{{ $salaSelecionada->id }}">

                <input type="text" name="mensagem" required
                    class="flex-1 border rounded px-3 py-2"
                    placeholder="Escreve uma mensagem...">

                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Enviar mensagem
                </button>
            </form>

            <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-lg font-bold mb-4">
                        Tem a certeza que quer eliminar o grupo?
                    </h2>

                    <p class="text-sm text-gray-500 mb-6">
                        Esta ação não pode ser desfeita.
                    </p>

                    <div class="flex justify-end gap-2">
                        <button onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 rounded">
                            Cancelar
                        </button>

                        <form method="POST" action="{{ route('salas.destroy', $salaSelecionada->id) }}">
                            @csrf
                            @method('DELETE')

                            <button class="px-4 py-2 bg-red-600 text-white rounded">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else

            <div class="flex-1 flex items-center justify-center text-gray-400">
                Nenhuma sala selecionada
            </div>

        @endif

    </div>

</div>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function toggleNotificacoes() {
            document.getElementById('notificacoesBox').classList.toggle('hidden');
        }

        function toggleInviteBox() {
            document.getElementById('inviteBox').classList.toggle('hidden');
        }
    </script>
</x-layout>
