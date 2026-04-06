<x-layout>
    <form action="/login" method="POST">
        <input type="hidden" name="role" value="{{ request('role') }}">
        @csrf
        <h1 class="text-3xl font-bold text-center mt-30">Entrar</h1>

        <fieldset class="fieldset bg-base-200 border-base-300 mt-10 rounded-box w-xs border p-4 mx-auto">

            <label class="label" for="email">Email</label>
            <input class="input text-white" type="email" name="email" placeholder="O teu email" required />
            <x-forms.error name="email"/>

            <label class="label">Password</label>
            <input type="password" class="input text-white" name="password" placeholder="A tua palavra-passe" required />

            <button class="btn btn-neutral mt-4">Entrar</button>
        </fieldset>
    </form>
</x-layout>
