<div class="card small">
    <div class="card-header">
        <b>Vereadores</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.store') }}" method="post" class="row g-4" enctype="multipart/form-data">
            @csrf            

                <!-- Nome político -->
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nome político</label>
                    <input type="text" 
                        name="nome_politico"
                        class="form-control @error('nome_politico') is-invalid @enderror" 
                        value="{{ old('nome_politico') }}" required>
                    @error('nome_politico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Título -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Título</label>
                    <select class="form-select" name="titulo" required>
                        <option value="">Selecione um título</option>
                        <option value="vereador">Vereador</option>
                        <option value="vereadora">Vereadora</option>
                    </select>
                </div>

                <!-- Pavimento -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pavimento</label>
                    <select class="form-select" 
                            name="pavimento" required>
                        <option value="">Selecione um pavimento</option>
                        @foreach ($pavimentos as $pavimento)
                            <option value="{{ $pavimento->id }}">{{ $pavimento->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sala -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Sala</label>
                    <input type="text" class="form-control" name="sala" value="{{ old('sala') }}">
                </div>

                <!-- Logo partido -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Logo do Partido</label>
                    <input class="form-control" type="file" name="logo_partido">
                </div>                                    
        </form>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Criar</button>
    </div>

</div> 