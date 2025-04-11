<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

        $users = User::all();
        return view('users.index', [
            'greeting' => 'Usuários',
            'users' => $users
        ]);
    }

    public function show(User $user) {
        return view('users.show', [
            'user' => $user
        ]);
    }

}
