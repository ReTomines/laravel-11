<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .slide {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .slide-content {
            display: flex;
            flex: 1;
            padding: 20px;
            gap: 20px;
        }
        .pavimento-column {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .localizacao-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            background-color: #ddd;
            padding: 5px 10px;
            text-transform: uppercase;
        }
        .vereador-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .vereador-titulo {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .vereador-nome {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .vereador-partido {
            color: #555;
            margin-bottom: 5px;
        }
        .gabinete {
            font-style: italic;
            color: #777;
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
                                <div class="vereador-titulo">{{ strtoupper($vereador->titulo) }}</div>
                                <div class="vereador-nome">
                                    {{ $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico }}
                                </div>
                                <div class="vereador-partido">{{ $vereador->partido->nome ?? 'Sem partido' }}</div>
                                <div class="gabinete">GAB: {{ $vereador->sala }}</div>
                            </div>
                        @endforeach
                        
                        @if(isset($setoresPorLocalizacao[$localizacao]))
                            <div class="localizacao-title">SETORES - {{ $localizacao }}</div>
                            @foreach($setoresPorLocalizacao[$localizacao] as $setor)
                                <div class="vereador-card">
                                    <div class="vereador-nome">{{ $setor->nome_setor }}</div>
                                    <div class="gabinete">SALA: {{ $setor->sala }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>