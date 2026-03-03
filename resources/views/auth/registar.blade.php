<x-layout>
    <form action="/register" method="POST">
        <input type="hidden" name="role" value="{{ request('role') }}">

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
            <legend class="fieldset-legend">Registar</legend>

            <label class="label" for="name">Nome</label>
            <input class="input text-white" name="name" placeholder="O teu nome" required />

            <label class="label" for="email">Email</label>
            <input class="input text-white" type="email" name="email" placeholder="O teu email" required />

            <label class="label">Password</label>
            <input type="password" class="input text-white" name="password" placeholder="A tua palavra-passe" required />

            <label class="label">Confirmar Password</label>
            <input type="password" class="input text-white" name="password_confirmation" placeholder="Confirma a tua palavra-passe" required/>

            <button class="btn btn-neutral mt-4" data-test="register-button">Registar</button>
        </fieldset>
    </form>
</x-layout>
