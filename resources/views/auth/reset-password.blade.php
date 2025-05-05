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
          <p class="register-box-msg fw-semibold">Redefinição de senha</p>
          <form action="{{route('password.update')}}" method="post">
          @csrf
           
            <input type="hidden" name="token" value="{{ request()->token }}"> 
            <div class="input-group mb-3">
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
              <input readonly type="email" 
                     name="email" 
                     class="form-control small-placeholder @error('email') is-invalid @enderror" placeholder="Email" value="{{ request()->email }}"/>
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
                <button type="submit" class="btn btn-primary">Redefinir senha</button>
            </div>
            <!--end::Row-->
          </form>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <!-- /.register-box -->
@endsection 