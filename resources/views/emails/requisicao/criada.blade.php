@component('mail::message')
    # Requisição Confirmada

    Livro: **{{ $requisicao->livros->Nome_livro }}**
    Data Requisição: {{ $requisicao->data_requisicao->format('d/m/Y') }}
    Data Entrega: {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}

    <img src="{{ asset('storage/'.$requisicao->livros->Imagem_da_capa) }}" style="width:120px; margin-top:10px;">

    Código da Requisição: {{ $requisicao->id }}

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
