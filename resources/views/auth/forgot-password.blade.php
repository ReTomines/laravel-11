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
          <p class="login-box-msg fw-semibold"> Redefinir senha</p>

          @session('status')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
          @endsession

          <form action="{{route('password.email')}}" method="post">
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
            
            <p class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Enviar token</button>
            </p>
            <!--end::Row-->
          </form>
            <div class="text-center small">
                <p class="mb-0"> <a href="{{route('login')}}" class="text-center"> Voltar ao Login </a> </p>
            </div>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
@endsection