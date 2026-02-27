<x-layout>
    <form action="/criar-autores" method="POST" enctype="multipart/form-data">
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

            <label class="label" for="Nome_autor">Nome</label>
            <input class="input text-white" name="Nome_autor" placeholder="Escreva o nome do autor" required />

            <label class="label">Foto do Autor/a</label>
            <input class="file-input file-input-bordered w-full text-white"
                   type="file"
                   name="Foto_autor"
                   accept="image/*"
                   id="Foto_autor"
                   required/>

            <button type="submit" class="btn btn-neutral mt-4">
                Colocar Autor/a
            </button>
        </fieldset>
    </form>
</x-layout>
