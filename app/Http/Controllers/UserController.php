<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        User::create($input);
        return redirect()
            ->route('users.index')
            ->with('status', 'Usuário criado com sucesso');
    }

    public function edit(User $user)
    {
        $user->load('profile','interests');
        $roles = Role::all();
        return view('users.edit', compact('user','roles'));;
    }

    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'exclude_if:password,null|min:6'
        ]);
        $user->fill($input);
        $user->save();

        return back()
            ->with('status', 'Usuário editado com sucesso');
    }

    public function updateProfile(User $user, Request $request)
    {
        $input = $request->validate([
            'type' => 'required',
            'address' => 'nullable'
        ]);

        UserProfile::updateOrCreate([
            'user_id' => $user->id,
        ], $input);
            
        return back()
            ->with('status', 'Perfil editado com sucesso');
    }

    public function updateInterests(User $user, Request $request)
    {
        $input = $request->validate([
            'interests' => 'nullable|array',
        ]);

        $user->interests()->delete();

        if(!empty($input['interests'])) {
            $user->interests()->createMany($input['interests']);
        }
        return back()
            ->with('status', 'Perfil editado com sucesso');
        
    }

    public function updateRoles(User $user, Request $request)
    {
        $input = $request->validate([
            'roles' => 'required|array',
        ]);
        $user->roles()->sync($input['roles']);
        return back()
            ->with('status', 'Perfil editado com sucesso');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('users.index')
            ->with('status', 'Usuário deletado com sucesso');
    }
}
