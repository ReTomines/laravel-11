<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    // -→ relação 1→1 (e criando um registro na tabela profile)
    // $user = User::with('profile')->find(1);
    // $user->profile()->create([
    //     'type' => 'PJ',
    //     'document_number' => '92387498234'
    // ]);
    // dd($user->profile->type);

    // -→ relação 1→N (e criando N registros na tabela posts para apenas um usuario)
    // $user = User::with('posts','profile')->find(1);
    // $user->posts()->create([
    //     'title' => 'Meu post de relacionamento 1→N',
    //     'body' => 'Meu texto aqui'
    // ]);

    // -→ relação N→N (tabela intermediária Pivot/user/role_user/roles)
    //$roles = Role::all();
    //dd($roles);

    // * associando um usuáro a um cargo (vários usuários podem pertencer a 1 cargo; 1 cargo pode pertencer a vários usuários)
    $user = User::with('roles')->find(2);
    // $user->roles()->attach(2);
    // $user->roles()->detach(1); 
    $user->roles()->sync([1]);
    dd($user);


    return view('welcome');
});

// Route::get ('rota/', ['nome do controller', 'nome do método']);
Route::get('admin/usuarios', [UserController::class, 'index']);
Route::get('admin/usuarios/{user}', [UserController::class, 'show']);