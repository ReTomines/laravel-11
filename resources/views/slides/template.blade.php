<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slides de Vereadores</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 15px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px; 
            margin: 0 auto;
        }
        
        .slide {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 5px;
            margin-bottom: 10px;
        }
        
        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e1e1e1;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 18px;
        }
        
        .location-title {
            background-color:rgba(88, 100, 107, 0.47);
            color: white;
            padding: 2px 5px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .councilor-card {
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #fff;
        }
        
        .councilor-name-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .councilor-title-name {
            display: flex;
            gap: 5px;
        }
        
        .councilor-title {
            color: #7f8c8d;
            font-size: 16px;
            text-transform: uppercase;
        }
        
        .councilor-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 16px;
        }
        
        .councilor-party-office {
            display: flex;
            gap: 10px;
        }
        
        .councilor-party {
            font-weight: bold;
            color: #2980b9;
        }
        
        .councilor-office {
            color: #34495e;
            font-size: 14px;
        }
        
        .vago {
            opacity: 0.7;
            background-color: #f9f9f9;
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            
            .slide {
                page-break-after: always;
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"> <!-- cabeçalho -->
            <h1>EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)</h1>
        </div>

        @foreach($vereadoresGrouped as $group) <!-- loop para agrupar os vereadores por localização -->
            <div class="slide"> <!-- conteúdo do slide -->

                @foreach($group as $localizacao => $vereadores)<!-- loop para exibir os vereadores por localização -->
                    <div class="location-title">{{ $localizacao }}</div> <!-- título da localização -->
                        
                        @foreach($vereadores as $vereador) <!-- loop para exibir os vereadores -->
                            <div class="councilor-card {{ $vereador->nome_politico === 'VAGO' ? 'vago' : '' }}">
                                
                                <div class="councilor-name-line">
                                    <div class="">
                                        <span class="councilor-title">{{ $vereador->titulo === 'vereador' ? 'VEREADOR' : 'VEREADORA' }}</span>
                                        <span class="councilor-name">{{ $vereador->nome_politico }}</span>
                                    </div>
                                    
                                    <div class="">
                                        <span class="councilor-party">
                                            @if(isset($vereador->partido->nome_partido) && $vereador->partido->nome_partido !== 'Sem partido')
                                                {{ $vereador->partido->nome_partido }}
                                            @else
                                                Sem partido
                                            @endif
                                        </span>
                                        <span class="councilor-office">GAB. {{ $vereador->sala }}</span>
                                    </div>
                                </div>

                            </div>

                        @endforeach

                @endforeach
            </div>
        @endforeach
    </div>
</body>
</html>