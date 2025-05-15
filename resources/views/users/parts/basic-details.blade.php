<div class="card small">
    <form action="{{route('users.update', $user->id)}}" method="post">
        @csrf
        @method('PUT') 
        <div class="card-header">
            <div><b>Dados Básicos</b></div>
        </div>
        <div class="card-body">

            <!-- Campo Nome -->
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" 
                    name="name" 
                    class="form-control form-control-sm @error('name') is-invalid @enderror" 
                    value="{{ old('name') ?? $user->name }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" 
                    name="email" 
                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                    value="{{ old('email') ?? $user->email }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo senha -->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password"
                    name="password" 
                    class="form-control form-control-sm @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Editar</button>
        </div>
    </form>
    
</div>    