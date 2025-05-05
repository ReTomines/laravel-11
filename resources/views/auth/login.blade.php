@extends('layouts.auth')

@section('body-class', 'login-page')

@section('content')
    <div class="login-box">

      <div class="login-logo">
        <a href="{{ route('login')}}"><b>video</b>Wall</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg fw-semibold">Login</p>
          <form action="{{route('login')}}" method="post">
            @csrf
            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
              <input type="email" 
                     name="email"
                     class="form-control small-placeholder @error('email') is-invalid @enderror" 
                     placeholder="Email" value="{{ old('email') }}"/>
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

            <!--begin::Row (checkbox 'remember me')-->
            <!--div class="row">
              <div class="col-8">
                <div class="form-check">
                  < input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label small" for="flexCheckDefault"> Lembre de mim </label>
                </div>
              </div>
            </div-->
            
            <p class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
            </p>
            <!--end::Row-->
          </form>
            <div class="text-center small">
                <p class="mb-1"><a href="{{route('password.email')}}">Esqueci minha senha</a></p>
                <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center"> Cadastre-se </a>
                </p>
            </div>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
@endsection