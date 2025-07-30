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
                    <a href="{{ route('slides.generate', ['format' => 'pdf']) }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Baixar PDF
                    </a>
                </div>
            </div>
            
            <div id="preview-container" class="bg-light p-3" style="min-height: 500px; border: 1px dashed #ccc;">
                
                @if(isset($vereadoresGrouped) && $vereadoresGrouped->count() > 0)
                    @foreach($vereadoresGrouped as $slideGroup)
                        <div style="margin-bottom: 40px; border: 1px solid #999; padding: 15px;">
                            <h4 style="text-align: center; background: #333; color: white; padding: 10px;">
                                EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)
                            </h4>
                            
                            <div style="display: flex; gap: 20px;">
                                @foreach($slideGroup as $localizacao => $vereadores)
                                    <div style="flex: 1;">
                                        <h5 class="localizacao-title">{{ $localizacao }}</h5>
                                        <div style="display: flex; flex-direction: column; gap: 10px;">
                                            @foreach($vereadores as $vereador)
                                                <div style="border: 1px solid #ddd; padding: 10px;">
                                                    <strong>{{ $vereador->titulo }} 
                                                        {{ $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico }}
                                                    </strong><br>
                                                    <small>{{ $vereador->partido->nome ?? 'Sem partido' }}</small><br>
                                                    <small>GAB: {{ $vereador->sala }}</small>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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