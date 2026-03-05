<x-layout>

    <div class="max-w-5xl mx-auto mt-10">

        <div class="max-w-4xl mx-auto mt-10">

            <h1 class="text-3xl font-bold mb-6">
                Meu Perfil
            </h1>

            <div class="grid grid-cols-2 gap-10">

                <div>

                    @if($user->foto)
                        <img src="{{ asset('storage/'.$user->foto) }}"
                             class="w-40 h-40 rounded-full object-cover">
                    @else
                        <div class="w-40 h-40 bg-gray-300 rounded-full"></div>
                    @endif

                    <form action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf

                        <input type="file" name="foto_user" class="file-input">

                        <button class="btn btn-primary mt-2">
                            Atualizar Foto
                        </button>

                    </form>

                </div>


                <div>

                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf

                        <label class="label">Nome</label>
                        <input type="text" name="name"
                               value="{{ $user->name }}"
                               class="input input-bordered w-full mb-4">

                        <label class="label">Email</label>
                        <input type="email" name="email"
                               value="{{ $user->email }}"
                               class="input input-bordered w-full mb-4">

                        <button class="btn btn-success">
                            Atualizar Perfil
                        </button>

                    </form>


                    <hr class="my-6">

                    <form action="{{ route('perfil.password') }}" method="POST">
                        @csrf

                        <label class="label">Nova Password</label>
                        <input type="password"
                               name="password"
                               class="input input-bordered w-full mb-3">

                        <label class="label">Confirmar Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="input input-bordered w-full mb-4">

                        <button class="btn btn-warning">
                            Alterar Password
                        </button>

                    </form>

                </div>

            </div>

            <h2 class="text-2xl font-bold mb-4">Histórico de Requisições</h2>

        <table class="table-auto w-full bg-gray-800 text-white rounded-lg overflow-hidden">

            <thead class="bg-gray-700">
            <tr>
                <th class="px-4 py-2">Livro</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Data</th>
            </tr>
            </thead>

            <tbody>

            @foreach(auth()->user()->requisicoes as $r)

                <tr class="border-t border-gray-700">
                    <td class="px-4 py-2">{{ $r->livros->Nome_livro ?? 'Livro removido' }}</td>
                    <td class="px-4 py-2">{{ $r->estado }}</td>
                    <td class="px-4 py-2">{{ $r->data_requisicao }}</td>
                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</x-layout>
