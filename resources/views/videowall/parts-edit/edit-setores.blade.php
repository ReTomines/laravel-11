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
        <b>Editar Setor</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.setores.update', $setor->id)}}" method="post" class="row g-3" enctype="multipart/form-data">
            @csrf            
            @method('PUT')
            
                <!-- Nome setor -->
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nome setor</label>
                    <input type="text" 
                        name="nome_setor"
                        class="form-control @error('nome_setor') is-invalid @enderror" 
                        value="{{ old('nome_setor', $setor->nome_setor) }}" required>
                    @error('nome_setor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pavimento -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Pavimento</label>
                    <select class="form-select" 
                            name="pavimento" required>
                        <option value="">Selecione um pavimento</option>
                        
                        @foreach ($pavimentos as $pavimento)
                            <option value="{{ $pavimento->id }}"
                                @if(old('pavimento', $setor->pavimento) == $pavimento->id) selected @endif>
                                {{ $pavimento->nome }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Sala -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Sala</label>
                    <input type="text" class="form-control" name="sala" value="{{ old('sala', $setor->sala) }}">
                </div>

                <!-- Ícone -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ícone</label>
                    <input class="form-control @error('icone') is-invalid @enderror" 
                           type="file" 
                           name="icone">
                    @error('icone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($setor->icone)
                        <div class="mt-2">
                            <small>Icone:</small><br>
                            <img src="{{ asset('storage/' . $setor->icone) }}" alt="Icone" style="max-height: 50px;">
                        </div>
                    @endif

                </div>       
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="{{ route('videowall.index', ['tab' => 'setores']) }}" class="btn btn-secondary">Cancelar</a>
                </div>
        </form>
    </div>
</div>