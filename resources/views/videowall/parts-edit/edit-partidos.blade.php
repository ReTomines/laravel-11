@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if($errors->has('duplicado'))
    <div class="alert alert-danger">
        {{ $errors->first('duplicado') }}
    </div>
@endif

<div class="card small">
    <div class="card-header">
        <b>Editar Partido</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.partidos.update', $partido->id) }}" method="post" class="row g-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nome Partido -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Nome Partido</label>
                <input type="text" 
                    name="nome_partido"
                    class="form-control @error('nome_partido') is-invalid @enderror" 
                    value="{{ old('nome_partido', $partido->nome_partido) }}" required>
                @error('nome_partido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Logo partido -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Logo do Partido</label>
                <input class="form-control @error('logo') is-invalid @enderror" 
                       type="file" 
                       name="logo">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($partido->logo)
                    <div class="mt-2">
                        <small>Logo atual:</small><br>
                        <img src="{{ asset('storage/' . $partido->logo) }}" alt="Logo do partido" style="max-height: 50px;">
                    </div>
                @endif
            </div>        
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>