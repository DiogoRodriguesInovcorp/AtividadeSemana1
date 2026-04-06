<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $review = Review::create([
            'user_id' => Auth::id(),
            'livro_id' => $request->livro_id,
            'requisicao_id' => $request->requisicao_id,
            'comentario' => $request->comentario,
            'estado' => 'suspenso',
            'rating' => $request->rating,
        ]);

        logAction(
            'Reviews',
            $review->id,
            'Criou uma review'
        );

        $bibliotecarios = User::where('role', 'bibliotecario')->get();

        foreach ($bibliotecarios as $bibliotecario) {
            Mail::raw(
                "Nova review criada!\n\n".
                "Responsável: ".Auth::user()->name."\n".
                "Email: ".Auth::user()->email."\n".
                "Livro: ".$review->livro->Nome_livro."\n".
                "Comentário: ".$review->comentario."\n".
                "Avaliação: ".$review->rating." estrelas\n".
                "Link para detalhes: ".route('reviews.show', $review->id),
                function($msg) use ($bibliotecario){
                    $msg->to($bibliotecario->email)
                        ->subject('Nova Review Recebida');
                }
            );
        }

        // EMAIL PARA O USUÁRIO (cidadão) avisando que a review foi enviada
        Mail::raw(
            "Olá ".Auth::user()->name."!\n\n".
            "A sua review sobre o livro '".$review->livro->Nome_livro."' foi enviada com sucesso e está a ser avaliada pelo admin.\n".
            "Obrigado por contribuir!",
            function($msg) use ($review) {
                $msg->to($review->user->email)
                    ->subject('Review enviada e em avaliação');
            }
        );

        return redirect()->route('livros.requisicoes')->with('success','Review enviada com sucesso! Está a ser avaliada pelo admin.');
    }

    public function index(){
        $reviews = Review::latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::with('user')->findOrFail($id);

        $review->update([
            'estado' => $request->estado,
            'justificacao' => $request->justificacao
        ]);

        logAction(
            'Reviews',
            $review->id,
            'Alterou estado para: '.$request->estado
        );

        // EMAIL USER
        Mail::raw(
            "A sua review foi {$request->estado}" .
            ($request->estado == 'recusado' ? "\nMotivo: ".$request->justificacao : ''),
            function($msg) use ($review){
                $msg->to($review->user->email)
                    ->subject('Estado da Review');
            }
        );

        return redirect()->route('admin.reviews')->with('success','Review atualizada!');
    }

    public function create(Requisicao $requisicao)
    {
        return view('livros.review', compact('requisicao'));
    }

    public function show($id)
    {
        // Busca a review com o usuário e o livro relacionado
        $review = Review::with('user', 'livro')->findOrFail($id);

        // Livro associado à review
        $livro = $review->livro;

        return view('admin.review-show', compact('review','livro'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('admin.reviews')->with('success', 'Review removida com sucesso!');
    }
}
