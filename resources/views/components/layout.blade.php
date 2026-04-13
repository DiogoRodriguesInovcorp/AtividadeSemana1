@props([
    'title' => 'Biblioteca'
])

<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ $title }} </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-primary">
<x-nav/>

@auth
<a href="{{ route('salas.index') }}"
class="fixed bottom-6 right-6 bg-blue-600 text-white text-2xl rounded-full w-14 h-14 flex items-center justify-center shadow-xl hover:bg-blue-700 transition">

    💬
</a>
@endauth

<main class="max-w-3xl mx-auto mt-6">
    {{ $slot }}
</main>
</body>
</html>
