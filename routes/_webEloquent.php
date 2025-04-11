<?php

use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    // *** ARQUIVO DE ESTUDO DO ELOQUENT ***

    // *** criar/buscar/atualizar/deletar registros no bd com eloquent ***

    // -→ criando um registro no bd com eloquent
    // $post = new \App\Models\Post();
    // $post->title = 'Primeiro Post';
    // $post->body = 'Texto texto';
    // $post->save();

    // *outra forma de criar um registro no bd
    // $post = \App\Models\Post::create([
    //     'title' => 'Primeiro Post',
    //     'body' => 'Texto texto'
    // ]);

    // -→ realizando buscas
    // $post = Post::find(2); //busca pelo id
    // $post = Post::where('title', 'Primeiro Post')->first(); //busca pelo title
    // $post = Post::where('title', 'LIKE', '%Post%')->get(); // busca pelo title com LIKE
    // $post = Post::all(); //busca todos os registros

    // -→ realizando update/atualizações no bd
    // $post = Post::find(2);
    // $post->title = 'Segundo Post';
    // $post->save();

    // *outra forma de realizar update/atualizações no banco
    // $input = [
    //     'title' => 'Alteração no meu primeiro Post',
    //     'body' => 'Meu novo texto'
    // ];
    // $post = Post::find(1);
    // $post->fill($input);
    // $post->save();
    
    // -→ realizando exclusão/delete no bd
    // $post = Post::find(1);
    // $post->delete();
    // dd($post);

    return view('welcome');
});

// Route::get ('rota/', ['nome do controller', 'nome do método']);
Route::get('admin/usuarios', [UserController::class, 'index']);
Route::get('admin/usuarios/{user}', [UserController::class, 'show']);