@extends('layouts.auth')

@section('body-class', 'register-page')

@section('content')
    <div class="register-box">
      <div class="register-logo">
        <a href="{{ route('login')}}"><b>video</b>Wall</a>
      </div>
      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg fw-semibold">Cadastrar usuário</p>
          <form action="{{route('register')}}" method="post">
          @csrf

            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-person"></span></div>
              <input type="text" 
                     name="name" 
                     class="form-control small-placeholder @error('name') is-invalid @enderror" placeholder="Nome" value="{{ old('name') }}"/>
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
              <input type="email" 
                     name="email" 
                     class="form-control small-placeholder @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}"/>
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
              <input type="password" 
                     name="password" 
                     class="form-control small-placeholder @error('password') is-invalid @enderror" 
                     placeholder="Senha"/>
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
              <input type="password" 
                     name="password_confirmation" 
                     class="form-control small-placeholder" 
                     placeholder="Cofirmar Senha" />
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            <!--end::Row-->
          </form>

          <p class="mb-0 text-center small"><br>
            <a href="{{route('login')}}" class="text-center"> Já sou cadastrado </a>
          </p>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <!-- /.register-box -->
@endsection 