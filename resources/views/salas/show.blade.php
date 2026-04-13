<x-layout title="Salas">

<div class="w-1/4 bg-white border-r overflow-y-auto">
    <div class="p-4 font-bold text-lg">Salas</div>

    @foreach($salas as $s)
        <a href="{{ route('salas.show', $s->id) }}"
           class="block p-4 hover:bg-gray-100 border-b
           {{ $s->id == $sala->id ? 'bg-gray-200' : '' }}">
            {{ $s->nome }}
        </a>
    @endforeach
</div>


<div class="flex-1 flex flex-col">

    <div class="p-4 border-b font-bold">
        {{ $sala->nome }}
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-2">
        @foreach($mensagens as $mensagem)
            @include('components.message', ['mensagem' => $mensagem])
        @endforeach
    </div>

    <form method="POST" action="{{ route('mensagens.store') }}" class="p-4 border-t flex">
        @csrf
        <input type="hidden" name="sala_id" value="{{ $sala->id }}">

        <input type="text" name="conteudo"
               class="flex-1 border rounded px-3 py-2"
               placeholder="Escreve uma mensagem...">

        <button class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">
            Enviar
        </button>
    </form>

</div>

</x-layout>
