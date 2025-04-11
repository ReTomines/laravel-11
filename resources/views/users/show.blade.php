@extends('layouts.app')

@section('title', 'Mostrar usuário')

@section('content')
    <h1>Mostrar usuários {{ $user->name }}</h1>

    @if ($user->id === 1)
        <div>Sou Admin</div>
    @else
        <div>Não sou Admin</div>
    @endif
@endsection