<?php
use App\Exports\LivrosExport;
use App\Http\Controllers\AlertasDisponibilidadeController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\ReviewController;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\GoogleBooksController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CheckoutController;

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
        Route::get('/criar-admin', [AdminController::class, 'criarAdmin'])->name('admin.criar-admin');
        Route::post('/criar-admin', [AdminController::class, 'storeAdmin'])->name('admin.store-admin');
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

Route::middleware(['auth', 'verified'])->group(function() {

    // Menu de Requisições
    Route::get('/requisicoes', [RequisicaoController::class, 'index'])->name('livros.requisicoes');

    Route::post('/requisicoes', [RequisicaoController::class, 'store'])->name('requisicoes.store');

    Route::get('/admin/pesquisar', [GoogleBooksController::class, 'index'])->name('admin.pesquisar');

    Route::get('/admin/resultados', [GoogleBooksController::class, 'pesquisar'])->name('admin.resultados');

    Route::post('/admin/guardar', [GoogleBooksController::class, 'guardar'])->name('admin.guardar');

    // Todas as requisições (só admin/bibliotecario)
    Route::get('/requisicoes-todas',
        [RequisicaoController::class, 'todas']
    )->middleware('role:bibliotecario')
        ->name('admin.requisicoes-todas');

    Route::post('/livros/{livro}/requisitar', [RequisicaoController::class, 'store'])
        ->name('requisicoes.store');

    // Confirmar recepção (só admins)
    Route::post('/requisicoes/{requisicao}/confirmar', [RequisicaoController::class, 'confirmar'])
        ->middleware('role:bibliotecario')
        ->name('requisicoes.confirmar');

    Route::get('/perfil', function () {
        return view('auth.perfil');
    })->name('auth.perfil');

    Route::post('/requisicoes/{id}/devolver', [RequisicaoController::class,'devolver']);
});

Route::middleware(['auth', 'verified'])->group(function(){

    Route::get('/perfil',[PerfilController::class,'index'])
        ->name('perfil');

    Route::post('/perfil/update',[PerfilController::class,'update'])
        ->name('perfil.update');

    Route::post('/perfil/password',[PerfilController::class,'updatepassword'])
        ->name('perfil.password');

    Route::post('/perfil/foto',[PerfilController::class,'updatefoto'])
        ->name('perfil.foto');

    Route::get('/admin/reviews', [ReviewController::class,'index'])
        ->name('admin.reviews')
        ->middleware('role:bibliotecario');

    Route::get('/admin/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::patch('/admin/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('/admin/reviews', [ReviewController::class,'store'])
        ->name('reviews.store');

    Route::get('/livros/{requisicao}/review', [ReviewController::class, 'create'])
        ->name('livros.review');

    Route::delete('admin/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});

Route::post('/show-livros', [AlertasDisponibilidadeController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('alerta.disponibilidade.store');

    Route::middleware('auth')->group(function () {

    Route::get('/Pagamento_livros/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');

    Route::post('/Pagamento_livros/carrinho/adicionar/{livro}', [CarrinhoController::class, 'adicionar'])->name('carrinho.add');

    Route::delete('/Pagamento_livros/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remove');

    Route::get('/Pagamento_livros/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/Pagamento_livros/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/Pagamento_livros/checkout/pagamento/{id}', [CheckoutController::class, 'pagamento'])->name('checkout.pagamento');
    Route::get('/Pagamento_livros/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/Pagamento_livros/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

Route::get('/admin/encomendas', [CheckoutController::class, 'encomendas'])
    ->middleware('role:bibliotecario')
    ->name('admin.encomendas');
