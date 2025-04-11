@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
    <h1 class="title">{{ $greeting }}</h1>
    <img width="100" src="{{ Vite::asset('resources/images/praia.jpg') }}" alt="">

    @foreach ($users as $user)
        <div class="user-name">{{ $user->name }}</div>
    @endforeach

@endsection