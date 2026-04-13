<div class="p-2 rounded
    {{ $mensagem->user_id == auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-200' }}">

    <div class="text-sm font-bold">
        {{ $mensagem->user->name }}
    </div>

    <div>
        {{ $mensagem->mensagem }}
    </div>

    <div class="text-xs text-gray-500">
        {{ $mensagem->created_at->format('H:i') }}
    </div>
</div>
