<x-layout>
    <form action="/criar-livros" method="POST" enctype="multipart/form-data">
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

            <label class="label" for="name">ISBN</label>
            <input class="input text-white" type="text"  name="ISBN" id="isbn" placeholder="ex.: 978-65-89999-01-3" maxlength="17" required />

            <label class="label" for="name">Nome do livro</label>
            <input class="input text-white" name="Nome_livro" placeholder="Coloca o nome do livro" required />

            <label class="label">Editora</label>
            <select name="Editora_id" class="select">
                @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}">
                        {{ $editora->Nome_editora }}
                    </option>
                @endforeach
            </select>

            <label class="label">Autor/s</label>

            <div class="relative">
                <select id="autorSelect" class="select select-bordered w-full">
                    <option disabled selected>Selecionar autor</option>
                    @foreach($autores as $autor)
                        <option value="{{ $autor->id }}">
                            {{ $autor->Nome_autor }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="autorTags" class="flex flex-wrap gap-2 mt-3"></div>

            <label class="label">Bibliografia</label>
            <textarea
                name="Bibliografia"
                rows="6"
                class="textarea textarea-bordered w-full text-white"
                placeholder="Coloca a bibliografia do livro"
            ></textarea>

            <label class="label">Imagem da Capa</label>
            <input class="file-input file-input-bordered w-full text-white"
                   type="file"
                   name="Imagem_da_capa"
                   accept="image/*"
                   id="imageminput"
                   required/>

            <label class="label">Preço</label>

            <div class="flex items-center text-white">
                <input
                    type="number"
                    name="Preco"
                    step="0.01"
                    min="0"
                    class="input rounded-r-none w-full"
                    placeholder="ex.: 14,30"
                    required
                />
                <span class="bg-base-300 px-3 py-2 rounded-r-lg">
                    €
                </span>
            </div>

            <button type="submit" class="btn btn-neutral mt-4" data-test="register-button">Colocar Livro</button>
        </fieldset>

        <script>
            document.getElementById('isbn').addEventListener('input', function (e) {
                let value = e.target.value.replace(/[^0-9]/g, '');

                if (value.length > 13) value = value.slice(0, 13);

                let formatted = value;
                if (value.length > 3)
                    formatted = value.slice(0,3) + '-' + value.slice(3);
                if (value.length > 5)
                    formatted = value.slice(0,3) + '-' + value.slice(3,5) + '-' + value.slice(5);
                if (value.length > 10)
                    formatted = value.slice(0,3) + '-' + value.slice(3,5) + '-' + value.slice(5,10) + '-' + value.slice(10);
                if (value.length > 12)
                    formatted = value.slice(0,3) + '-' + value.slice(3,5) + '-' + value.slice(5,10) + '-' + value.slice(10,12) + '-' + value.slice(12);

                e.target.value = formatted;
            });
        </script>

        <script>
            const select = document.getElementById('autorSelect');
            const tagsContainer = document.getElementById('autorTags');

            let autoresSelecionados = [];

            select.addEventListener('change', function () {
                const autorId = select.value;
                const autorNome = select.options[select.selectedIndex].text;

                if (autoresSelecionados.includes(autorId)) return;

                autoresSelecionados.push(autorId);

                const tag = document.createElement('div');
                tag.className = "bg-orange-500 text-black px-3 py-1 rounded-full flex items-center gap-2";
                tag.innerHTML = `
            ${autorNome}
            <button type="button" class="font-bold">&times;</button>
            <input type="hidden" name="autores[]" value="${autorId}">
        `;

                tag.querySelector('button').addEventListener('click', function () {
                    autoresSelecionados = autoresSelecionados.filter(id => id !== autorId);
                    tag.remove();
                });

                tagsContainer.appendChild(tag);

                select.selectedIndex = 0;
            });
        </script>

    </form>
</x-layout>
