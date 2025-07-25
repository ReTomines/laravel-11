<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .slide { 
            page-break-after: always; 
            width: 100%;
            height: 100vh;
            position: relative;
            background-color: #f5f5f5;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .pavimento-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            background-color: #ddd;
            padding: 5px 10px;
        }
        .vereador-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .vereador-card {
            width: 200px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: white;
        }
        .vereador-nome {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .vereador-partido {
            font-size: 12px;
            color: #666;
        }
        .gabinete {
            font-size: 11px;
            margin-top: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="slide">
        <div class="header">EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)</div>
        
        @foreach($vereadoresPorPavimento as $pavimento => $vereadores)
            <div class="pavimento-title">{{ $pavimento }}º PAVIMENTO</div>
            
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
            
            @if(isset($setoresPorPavimento[$pavimento]))
                <div class="pavimento-title">SETORES - {{ $pavimento }}º PAVIMENTO</div>
                <div class="vereador-container">
                    @foreach($setoresPorPavimento[$pavimento] as $setor)
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