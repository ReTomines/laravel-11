<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos anteriores mantidos */
        .localizacao-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            background-color: #ddd;
            padding: 5px 10px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="slide">
        <div class="header">EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)</div>
        
        @foreach($vereadoresPorLocalizacao as $localizacao => $vereadores)
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
        @endforeach
    </div>
</body>
</html>