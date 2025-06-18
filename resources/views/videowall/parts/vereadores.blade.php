@if($errors->has('duplicado'))
    <div class="alert alert-danger">
        {{ $errors->first('duplicado') }}
    </div>
@endif

<div class="card small">
    <div class="card-header">
        <b>Vereadores</b>
    </div>

    <div class="card-body">
        <form action="{{ route('videowall.vereadores.store') }}" method="post" class="row g-4" enctype="multipart/form-data">
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
                <div class="col-md-4">
                    <label class="form-label fw-bold">Título</label>
                    <select name="titulo"
                            class="form-select @error('titulo') is-invalid @enderror" 
                            required>
                        <option value="">Selecione um título</option>
                        <option value="vereador">Vereador</option>
                        <option value="vereadora">Vereadora</option>
                    </select>
                </div>

                <!-- Abreviação título -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Abreviação título</label>
                    <input type="text" 
                        name="abrev_titulo"
                        class="form-control @error('abrev_titulo') is-invalid @enderror" 
                        value="{{ old('abrev_titulo') }}" required>
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
                            <option value="{{ $pavimento->id }}">{{ $pavimento->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sala -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Sala</label>
                    <input type="text" 
                           class="form-control @error('sala') is-invalid @enderror" 
                           name="sala" 
                           value="{{ old('sala') }}" required>
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
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('videowall.index', ['tab' => 'vereadores']) }}" class="btn btn-secondary">Cancelar</a>
                </div>
        </form>
    </div>  
</div> 