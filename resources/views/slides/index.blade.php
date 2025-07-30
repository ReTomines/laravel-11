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
                                                <div style="border: 1px solid #ddd; padding: 15px; display: flex; align-items: center; gap: 20px; position: relative; height: 110px;">
                                                    @if($vereador->nome_politico == 'VAGO')
                                                        <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #eee; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; color: #999; font-size: 12px;">
                                                            <span>VAGO</span>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $vereador->foto_ver) }}" 
                                                            alt="{{ $vereador->nome_politico }}" 
                                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;"
                                                            onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                                    @endif
                                                    
                                                    <div style="flex: 1;">
                                                        <div style="font-weight: bold; font-size: 13px; color: #555;">{{ strtoupper($vereador->titulo) }}</div>
                                                        <div style="font-weight: bold; font-size: 16px;">{{ $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico }}</div>
                                                        
                                                        @if(isset($vereador->partido->nome) && $vereador->partido->nome != 'Sem partido')
                                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                                                            @if(isset($vereador->partido->logo))
                                                                <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                                                    alt="{{ $vereador->partido->nome }}" 
                                                                    style="width: 36px; height: 36px; object-fit: contain;"
                                                                    onerror="this.style.display='none'">
                                                            @endif
                                                            <span>{{ $vereador->partido->nome }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div style="position: absolute; right: 15px; display: flex; align-items: center; gap: 8px; font-size: 16px; color: #777;">
                                                        @if(isset($vereador->partido->logo) && $vereador->nome_politico != 'VAGO')
                                                            <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                                                alt="{{ $vereador->partido->nome }}" 
                                                                style="width: 28px; height: 28px; object-fit: contain;"
                                                                onerror="this.style.display='none'">
                                                        @endif
                                                        <span>GAB. {{ $vereador->sala }}</span>
                                                    </div>
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