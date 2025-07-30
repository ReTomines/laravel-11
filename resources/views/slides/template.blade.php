<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos base mantidos */
        .vereador-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            height: 100px;
            position: relative; /* Para posicionamento absoluto do gabinete */
        }
        .vereador-foto {
            width: 80px;
            height: 80px;
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
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }
        .vereador-nome {
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .vereador-partido {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .partido-logo {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
        .gabinete-info {
            position: absolute;
            right: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: #777;
        }
        .vago-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            color: #999;
            font-size: 12px;
        }
        .partido-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .partido-logo {
            width: 40px;  /* Aumentado de 24px */
            height: 40px; /* Aumentado de 24px */
            object-fit: contain;
        }
        .gabinete-info .partido-logo {
            width: 30px;  /* Aumentado de 16px */
            height: 30px; /* Aumentado de 16px */
        }
        .vereador-card {
            padding: 15px; /* Aumentado o padding */
            gap: 20px;    /* Aumentado o espaçamento */
            height: 120px; /* Aumentado a altura */
        }
        .vereador-foto {
            width: 90px;  /* Aumentado de 80px */
            height: 90px; /* Aumentado de 80px */
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
                                    <div class="partido-container">
                                        @if(isset($vereador->partido->logo))
                                            <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                                 alt="{{ $vereador->partido->nome }}" 
                                                 class="partido-logo"
                                                 onerror="this.style.display='none'">
                                        @endif
                                        <span>{{ $vereador->partido->nome }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="gabinete-info">
                                    @if(isset($vereador->partido->logo) && $vereador->nome_politico != 'VAGO')
                                        <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                             alt="{{ $vereador->partido->nome }}" 
                                             class="partido-logo"
                                             style="width: 20px; height: 20px;"
                                             onerror="this.style.display='none'">
                                    @endif
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