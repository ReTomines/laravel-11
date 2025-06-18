@if($errors->has('duplicado'))
    <div class="alert alert-danger">
        {{ $errors->first('duplicado') }}
    </div>
@endif

<div class="card small">
    <div class="card-header">
        <b>Partidos</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.partidos.store') }}" method="post" class="row g-3" enctype="multipart/form-data">
            @csrf            

                <!-- Nome Partido -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nome Partido</label>
                    <input type="text" 
                        name="nome_partido"
                        class="form-control @error('nome_partido') is-invalid @enderror" 
                        value="{{ old('nome_partido') }}" required>
                    @error('nome_partido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo partido -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Logo do Partido</label>
                    <input class="form-control" type="file" name="logo">
                </div>        
                
                <div class="form-check">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('videowall.index', ['tab' => 'partidos']) }}" class="btn btn-secondary">Cancelar</a>
                </div>
        </form>
    </div>
</div> 