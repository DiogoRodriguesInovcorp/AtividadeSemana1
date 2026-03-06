@component('mail::message')
    # Lembrete de Devolução

    Olá {{ $requisicao->user->name }},

    O livro **{{ $requisicao->livros->Nome_livro }}** deve ser devolvido **amanhã ({{ $requisicao->data_prevista_entrega->format('d/m/Y') }})**.

    Por favor, não se esqueça de devolver a tempo para evitar atrasos.

    @component('mail::button', ['url' => url('/requisicoes')])
        Ver minhas requisições
    @endcomponent

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
