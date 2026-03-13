<?php

namespace App\Http\Controllers;

use App\Models\Autores;
use App\Models\Editoras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Livro;
use Illuminate\Support\Facades\DB;


class GoogleBooksController extends Controller
{
    public function index()
    {
        return view('admin.pesquisar');
    }

    public function pesquisar(Request $request)
    {
        $query = $request->q ?? '';

        if(!$query){
            return redirect()->back();
        }

        $local = Livro::with('autores','editoras')
            ->where('Nome_livro','LIKE','%'.$query.'%')
            ->paginate(3);

        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $query,
            'maxResults' => 10
        ]);

        if ($response->failed()) {
            return back()->with('error','Erro ao ligar à API.');
        }

        $livrosApi = $response->json()['items'] ?? [];

        return view('admin.resultados', [
            'livros' => null,
            'livrosApi' => $livrosApi,
            'query' => $query
        ]);
    }

    public function guardar(Request $request)
    {

        // evitar duplicados
        if(Livro::where('ISBN',$request->isbn)->exists()){
            return back()->with('success','Livro já existe na biblioteca');
        }

        DB::beginTransaction();

        try {

            // EDITORA
            $editora = Editoras::firstOrCreate(
                ['Nome_editora' => $request->editora],
                ['Logo_editora' => 'fotos/8svQrZfbzA4f083fbzLH61VG5znKQLpHjigqQ6pk.webp']
            );

            // LIVRO
            $livro = Livro::create([
                'Nome_livro' => $request->titulo,
                'ISBN' => $request->isbn,
                'Bibliografia' => $request->descricao,
                'Imagem_da_capa' => $request->capa,
                'Editora_id' => $editora->id,
                'Preco' => $request->preco ?? 0
            ]);

            // AUTORES
            $autores = explode(',', $request->autor);

            foreach($autores as $nomeAutor){

                $autor = Autores::firstOrCreate(
                    ['Nome_autor' => trim($nomeAutor)],
                    ['Foto_autor' => 'fotos/Foto_default.avif']
                );

                $livro->autores()->attach($autor->id);

            }

            DB::commit();

        } catch (\Exception $e){
            DB::rollback();
            return back()->with('error','Erro ao importar livro');

        }

        return back()->with('success','Livro importado com sucesso!');
    }
}
