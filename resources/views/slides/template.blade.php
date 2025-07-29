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
        }
        .column {
            flex: 1;
            padding: 0 10px;
        }
        .localizacao-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            background-color: #ddd;
            padding: 5px 10px;
            text-transform: uppercase;
        }
        .vereador-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .vereador-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: calc(50% - 20px);
            box-sizing: border-box;
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
                    <div class="column">
                        <div class="localizacao-title">{{ $localizacao }}</div>
                        
                        <div class="vereador-container">
                            @foreach($vereadores as $vereador)
                                <div class="vereador-card">
                                    <div class="vereador-titulo">{{ strtoupper($vereador->titulo) }}</div>
                                    <div class="vereador-nome">{{ $vereador->nome_politico }}</div>
                                    <div class="vereador-partido">{{ $vereador->partido->nome ?? 'Sem partido' }}</div>
                                    <div class="gabinete">GAB: {{ $vereador->sala }}</div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(isset($setoresPorLocalizacao[$localizacao]))
                            <div class="localizacao-title">SETORES - {{ $localizacao }}</div>
                            <div class="vereador-container">
                                @foreach($setoresPorLocalizacao[$localizacao] as $setor)
                                    <div class="vereador-card">
                                        <div class="vereador-nome">{{ $setor->nome_setor }}</div>
                                        <div class="gabinete">SALA: {{ $setor->sala }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>