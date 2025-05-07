@extends('layouts.default')
@section('page-title', 'Adicionar Usuário')
@section('content')
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <!-- Campo Nome -->
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" 
                   name="email" 
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo senha -->
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Senha</label>
            <input type="password"
                   name="password" 
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>

@endsection