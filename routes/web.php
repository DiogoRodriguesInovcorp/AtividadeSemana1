<?php
use App\Exports\LivrosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/index', [LivroController::class, 'index']);
Route::get('/escolher-login', function () {
    return view('auth.escolher-login');
});

Route::get('/escolher-registo', function () {
    return view('auth.escolher-registo');
});
Route::get('/livros', [LivroController::class, 'livros']);
Route::get('/autores', [LivroController::class, 'autores']);
Route::get('/editoras', [LivroController::class, 'editoras']);
Route::get('/autores/{autor}', [LivroController::class, 'showautores'])->name('autores.show');
Route::get('/editoras/{editora}', [LivroController::class, 'showeditoras'])->name('editoras.show');
Route::get('/livros/exportar', function () {
    return Excel::download(new LivrosExport, 'livros.xlsx');
})->name('livros.exportar');

Route::get('/livros/{livro}', [LivroController::class, 'show'])->name('livros.show');
Route::middleware(['auth', 'verified'])->group(function () {



    Route::get('/criar', [LivroController::class, 'criar']);
    Route::middleware('can:Admin_ver')->group(function () {
        Route::get('/criar-livros', [AdminController::class, 'criarlivros']);
        Route::post('/criar-livros', [AdminController::class, 'storelivros']);
        Route::get('/criar-autores', [AdminController::class, 'criarautores']);
        Route::post('/criar-autores', [AdminController::class, 'storeautores']);
        Route::get('/criar-editoras', [AdminController::class, 'criareditoras']);
        Route::post('/criar-editoras', [AdminController::class, 'storeeditoras']);

        Route::delete('/livros/{livro}', [AdminController::class, 'destroy'])
            ->name('livros.destroy');
    });

    Route::delete('logout', [LivroController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'verified', 'role:bibliotecario'])->group(function () {
    Route::get('/criar', function () {
        return view('admin.criar');
    });
});
