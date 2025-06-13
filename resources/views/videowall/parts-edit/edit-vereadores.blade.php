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
        <b>Editar Vereador</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.vereadores.update', $vereador->id) }}" method="post" class="row g-4" enctype="multipart/form-data">
            @csrf 
            @method('PUT')

                <!-- Nome político -->
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nome político</label>
                    <input type="text" 
                           name="nome_politico"
                           class="form-control @error('nome_politico') is-invalid @enderror" 
                           value="{{ old('nome_politico', $vereador->nome_politico) }}" required>
                    @error('nome_politico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Título -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Título</label>
                    <select name="titulo"
                            class="form-select @error('titulo') is-invalid @enderror"
                            required>
                        <option value="">Selecione um título</option>
                        <option value="vereador" 
                                {{ old('titulo', $vereador->titulo) == 'vereador' ? 'selected' : '' }}>Vereador</option>
                        <option value="vereadora"
                                {{ old('titulo', $vereador->titulo) == 'vereadora' ? 'selected' : '' }}>Vereadora</option>
                    </select>
                </div>

                <!-- Abreviação título -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Abreviação título</label>
                    <input type="text" 
                        name="abrev_titulo"
                        class="form-control @error('abrev_titulo') is-invalid @enderror" 
                        value="{{ old('abrev_titulo', $vereador->abrev_titulo) }}" required>
                    @error('abrev_titulo')
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
                                    @if(old('pavimento', $vereador->pavimento) == $pavimento->id) selected @endif >
                                    {{ $pavimento->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sala -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Sala</label>
                    <input type="text" 
                           class="form-control @error('sala') is-invalid @enderror" 
                           name="sala" 
                           value="{{ old('sala', $vereador->sala) }}" required>
                    @error('sala')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Partido -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Partido</label>

                    <div class="row g-3 align-items-center">

                        <!-- Select Partido -->
                        <div class="col-md-6">    

                            <select class="form-select" 
                                    name="partido" 
                                    id="selectPartido">
                                <option value="">Selecione um partido</option>

                                @foreach ($partidos as $partido)
                                    <option value="{{ $partido->id }}"
                                        {{ old('partido', $vereador->partido_id) == $partido->id ? 'selected' : '' }}
                                        data-logo="{{ asset('storage/' . $partido->logo) }}">
                                        {{ $partido->nome_partido }}
                                    </option>
                                @endforeach

                            </select>
                        </div>      

                        <!-- Logo Partido -->
                        <div class="col-md-4">
                            <img id="logoPartido" 
                                src="" 
                                alt="Logo do Partido" 
                                class="img-fluid border rounded"
                                style="width: auto; height: 40px; object-fit: contain; display: none;">
                        </div>
                    </div>
                </div>      

                <div class="form-check">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                </div>
        </form>
    </div>  
</div> 