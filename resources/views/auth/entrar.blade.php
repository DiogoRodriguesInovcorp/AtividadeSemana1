<x-layout>
    <form action="/login" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
            <legend class="fieldset-legend">Entrar</legend>

            <label class="label" for="email">Email</label>
            <input class="input text-white" type="email" name="email" placeholder="O teu email" required />
            <x-forms.error name="email"/>

            <label class="label">Password</label>
            <input type="password" class="input text-white" name="password" placeholder="A tua palavra-passe" required />

            <button class="btn btn-neutral mt-4">Entrar</button>
        </fieldset>
    </form>
</x-layout>
