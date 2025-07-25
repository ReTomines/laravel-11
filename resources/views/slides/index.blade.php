@extends('layouts.default')
@section('page-title', 'Slides')

@section('content')
    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gerar Slides</h3>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('slides.generate', ['format' => 'html']) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-eye"></i> Visualizar Slides
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('slides.generate', ['format' => 'pdf']) }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Baixar PDF
                    </a>
                </div>
            </div>
            
            <div id="preview-container" class="bg-light p-3" style="min-height: 500px; border: 1px dashed #ccc;">
                @if(isset($vereadores) && count($vereadores))
                    @foreach($vereadores->groupBy('pavimento') as $pavimento => $vereadoresPav)
                        <h4>{{ $pavimento }}º PAVIMENTO</h4>
                        <div class="row">
                            @foreach($vereadoresPav as $vereador)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $vereador->titulo }} {{ $vereador->nome_politico }}</h5>
                                            <p class="card-text">
                                                <small class="text-muted">{{ $vereador->partido->nome ?? 'Sem partido' }}</small><br>
                                                <small>GAB: {{ $vereador->sala }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-5">
                        Nenhum vereador cadastrado.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection