<x-layout>
    <form action="/criar-editoras" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">

            <label class="label" for="Nome_editora">Nome</label>
            <input class="input text-white" name="Nome_editora" placeholder="Escreva o nome da editora" required />

            <label class="label">Logo da editora</label>
            <input class="file-input file-input-bordered w-full text-white"
                   type="file"
                   name="Logo_editora"
                   accept="image/*"
                   id="Logo_editora"
                   required/>

            <button class="btn btn-neutral mt-4">Colocar Editora</button>
        </fieldset>
    </form>

</x-layout>

