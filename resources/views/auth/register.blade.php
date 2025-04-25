@extends('layouts.auth')

@section('body-class', 'register-page')

@section('content')
    <div class="register-box">
      <div class="register-logo">
        <a href="../index2.html"><b>video</b>Wall</a>
      </div>
      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg fw-semibold">Cadastrar usuário</p>
          <form action="{{route('register')}}" method="post">
          @csrf

            <div class="input-group mb-3">
              <input type="text" name="name" class="form-control small-placeholder" placeholder="Nome" />
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>

            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control small-placeholder" placeholder="Email" />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>

            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control small-placeholder" placeholder="Senha" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="input-group mb-3">
              <input type="password" name="password_confirmation" class="form-control small-placeholder" placeholder="Cofirmar Senha" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            <!--end::Row-->
          </form>

          <p class="mb-0 text-center small"><br>
            <a href="login.html" class="text-center"> Já sou cadastrado </a>
          </p>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <!-- /.register-box -->
@endsection
