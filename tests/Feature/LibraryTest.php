<?php

use App\Models\User;
use App\Models\Livro;
use App\Models\Editoras;
use App\Models\Requisicao;
use Illuminate\Foundation\Testing\RefreshDatabase;


//Teste de Criação de Requisição de Livro

it('permite criar uma requisição de livro', function () {
    $user = User::factory()->create();
    $editora = Editoras::factory()->create();

    $livro = Livro::factory()->create([
        'disponivel' => true,
        'Editora_id' => $editora->id
    ]);

    $response = $this->actingAs($user)->post('/requisicoes', [
        'livro_id' => $livro->id,
    ]);

    $response->assertStatus(302); // redireciona ou sucesso
    $this->assertDatabaseHas('requisicoes', [
        'user_id' => $user->id,
        'livro_id' => $livro->id,
        'estado' => 'ativa',
    ]);
});

//Teste de Validação de Requisição

it('não permite criar requisição sem livro válido', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/requisicoes', [
        'livro_id' => 9999, // id inválido
    ]);

    $response->assertSessionHasErrors('livro_id');
});

//Teste de Devolução de Livro

it('permite devolver um livro', function () {
    $user = User::factory()->create();
    $editora = Editoras::factory()->create();

    $livro = Livro::factory()->create([
        'disponivel' => false,
        'Editora_id' => $editora->id
    ]);

    $requisicao = Requisicao::factory()->create([
        'user_id' => $user->id,
        'livro_id' => $livro->id,
        'estado' => 'ativa',
    ]);

    $response = $this->actingAs($user)->post("/requisicoes/{$requisicao->id}/devolver");

    $response->assertStatus(302);
    $this->assertDatabaseHas('requisicoes', [
        'id' => $requisicao->id,
        'estado' => 'devolvido',
    ]);
});

//Teste de Listagem de Requisições por Utilizador

it('lista apenas as requisições do utilizador', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $editora = Editoras::factory()->create();
    $livro = Livro::factory()->create(['Editora_id' => $editora->id]);

    $r1 = Requisicao::factory()->create(['user_id' => $user1->id, 'livro_id' => $livro->id]);
    $r2 = Requisicao::factory()->create(['user_id' => $user2->id, 'livro_id' => $livro->id]);

    $response = $this->actingAs($user1)->get('/requisicoes');

    $response->assertStatus(200);

    $this->assertTrue(
        $response->viewData('requisicoes')->contains('id', $r1->id)
    );
});

//Teste de Stock na Encomenda de Livros

it('não permite requisitar livro sem stock', function () {
    $user = User::factory()->create();
    $editora = Editoras::factory()->create();
    $livro = Livro::factory()->create([
        'disponivel' => false,
        'Editora_id' => $editora->id
    ]);

    $response = $this->actingAs($user)->post('/requisicoes', [
        'livro_id' => $livro->id,
    ]);

    $response->assertSessionHasErrors();
    $this->assertDatabaseMissing('requisicoes', [
        'user_id' => $user->id,
        'livro_id' => $livro->id,
    ]);
});
