<?php

namespace App\Http\Controllers\Traits;

use App\Models\{Vereadores, Setores, Partidos};

trait VereadoresTrait
{
    protected function getGabinetesPorPavimento()
    {
        return [
            '3º PAVIMENTO' => ['301', '302', '303', '304', '305', '306'],
            '4º PAVIMENTO' => ['401', '402', '403', '404', '405', '406'],
            '5º PAVIMENTO' => ['501', '502', '503', '504', '505', '506'],
            '6º PAVIMENTO' => ['601', '602', '603', '604', '605', '606'],
            '7º PAVIMENTO' => ['701', '702', '703', '704', '705', '706'],
            '8º PAVIMENTO' => ['801', '802', '803', '804', '805', '806'],
            '9º PAVIMENTO' => ['901', '902', '903', '904', '905', '906'],
            '10º PAVIMENTO' => ['1001', '1002', '1003', '1004', '1005', '1006'],
            'PALÁCIO' => ['14A', '17B', '30B', '31B', '32B']
        ];
    }

    protected function getVereadoresOrdenados()
    {
        return Vereadores::with(['partido', 'localization'])
            ->orderBy('pavimento')
            ->orderBy('sala')
            ->get();
    }

    protected function getSetoresOrdenados()
    {
        return Setores::with('localization')
            ->orderBy('pavimento')
            ->get();
    }

    protected function criarEstruturaCompletaVereadores($vereadores)
    {
        $gabinetesPorPavimento = $this->getGabinetesPorPavimento();
        $vereadoresCompletos = collect();

        foreach ($gabinetesPorPavimento as $pavimento => $gabinetes) {
            foreach ($gabinetes as $gabinete) {
                $vereador = $vereadores->firstWhere(function($item) use ($gabinete, $pavimento) {
                    return $item->sala == $gabinete && 
                        $item->localization->nome == $pavimento;
                });

                if (!$vereador) {
                    $vereadoresCompletos->push((object)[
                        'titulo' => 'VEREADOR(A)',
                        'nome_politico' => 'VAGO',
                        'partido' => (object)['nome' => 'Sem partido'],
                        'sala' => $gabinete,
                        'localization' => (object)['nome' => $pavimento]
                    ]);
                } else {
                    $vereadoresCompletos->push($vereador);
                }
            }
        }

        return $vereadoresCompletos;
    }

    protected function agruparVereadoresPorLocalizacao($vereadoresCompletos)
    {
        $vereadoresPorLocalizacao = $vereadoresCompletos->groupBy(function($item) {
            return $item->localization->nome;
        });

        $order = [
            '3º PAVIMENTO', '4º PAVIMENTO', '5º PAVIMENTO', '6º PAVIMENTO',
            '7º PAVIMENTO', '8º PAVIMENTO', '9º PAVIMENTO', '10º PAVIMENTO',
            'PALÁCIO'
        ];

        return $vereadoresPorLocalizacao->sortBy(function($item, $key) use ($order) {
            return array_search($key, $order);
        });
    }

    protected function agruparParaSlides($vereadoresPorLocalizacao)
    {
        $vereadoresGrouped = collect([]);
        $tempGroup = collect([]);
        $count = 0;
        
        foreach ($vereadoresPorLocalizacao as $localizacao => $vereadores) {
            $tempGroup->put($localizacao, $vereadores);
            $count++;
            
            if ($count == 2 || $localizacao == 'PALÁCIO') {
                $vereadoresGrouped->push($tempGroup);
                $tempGroup = collect([]);
                $count = 0;
            }
        }
        
        if ($tempGroup->count() > 0) {
            $vereadoresGrouped->push($tempGroup);
        }

        return $vereadoresGrouped;
    }
}