<x-layout>
    <div class="min-h-screen flex items-center justify-center px-6">

        <div class="max-w-md w-full bg-gray-800 p-8 rounded-2xl shadow-xl">

            <h1 class="text-3xl font-bold text-orange-400 mb-4 text-center">
                Verificar Email
            </h1>

            <p class="text-gray-400 text-center mb-6">
                Enviámos um link de verificação para o teu email.
                Clica no link recebido para ativar a tua conta.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    class="w-full px-6 py-3 bg-orange-400 text-white rounded-xl shadow hover:bg-orange-500 transition">
                    Reenviar Email
                </button>
            </form>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 rounded-lg bg-green-600/20 border border-green-500 text-green-400 text-center">
                    Link reenviado com sucesso.
                </div>
            @endif


            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button
                    class="w-full px-6 py-3 border border-red-500 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition">
                    Sair
                </button>
            </form>

        </div>

    </div>
</x-layout>
