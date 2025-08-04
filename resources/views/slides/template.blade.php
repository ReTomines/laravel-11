<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos atualizados */
        .slide {
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
        .header {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 18px;
        }
        
        .slide-content {
            display: flex;
            gap: 20px;
        }
        
        .pavimento-column {
            flex: 1;
        }
        
        .localizacao-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            color: #666; /* Tom de cinza médio para títulos de pavimento */
            padding: 5px;
            background-color: #f0f0f0; /* Fundo cinza claro */
            border-radius: 4px;
        }
        
        .vereador-card {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            height: 80px; /* Altura reduzida */
            position: relative;
            background-color: white;
        }
        
        .vereador-foto {
            width: 60px; /* Reduzido */
            height: 60px; /* Reduzido */
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        
        .vereador-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .vereador-titulo {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 12px;
            color: #888; /* Tom de cinza para títulos */
            text-transform: uppercase;
        }
        
        .vereador-nome {
            font-size: 16px;
            margin-bottom: 3px;
            font-weight: bold;
            color: #333;
        }
        
        .partido-info {
            font-size: 13px;
            color: #555;
            margin-top: 2px;
        }
        
        .gabinete-info {
            position: absolute;
            right: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #777;
            background-color: #f5f5f5;
            padding: 3px 8px;
            border-radius: 12px;
        }
        
        .vago-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    @foreach($vereadoresGrouped as $slideGroup)
        <div class="slide">
            <div class="header">EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)</div>
            
            <div class="slide-content">
                @foreach($slideGroup as $localizacao => $vereadores)
                    <div class="pavimento-column">
                        <div class="localizacao-title">{{ $localizacao }}</div>
                        
                        @foreach($vereadores as $vereador)
                            <div class="vereador-card">
                                @if($vereador->nome_politico == 'VAGO')
                                    <div class="vago-placeholder">
                                        <span>VAGO</span>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $vereador->foto_ver) }}" 
                                         alt="{{ $vereador->nome_politico }}" 
                                         class="vereador-foto"
                                         onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                @endif
                                
                                <div class="vereador-info">
                                    <div class="vereador-titulo">{{ strtoupper($vereador->titulo) }}</div>
                                    <div class="vereador-nome">
                                        {{ $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico }}
                                    </div>
                                    
                                    @if(isset($vereador->partido->nome) && $vereador->partido->nome != 'Sem partido')
                                    <div class="partido-info">
                                        Partido: {{ $vereador->partido->nome }}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="gabinete-info">
                                    <span>GAB. {{ $vereador->sala }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>