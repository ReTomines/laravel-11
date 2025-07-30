<?php

namespace App\Http\Controllers;

use App\Models\Vereadores;
use App\Models\Setores;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Para geração de PDF
use PhpOffice\PhpPresentation\PhpPresentation; // Para PPT (opcional)

class SlidesController extends Controller
{
    public function index()
    {
        // Obter vereadores ordenados
        $vereadores = Vereadores::with(['partido', 'localization'])
            ->orderBy('pavimento')
            ->orderBy('sala')
            ->get();

        // Obter setores
        $setores = Setores::with('localization')
            ->orderBy('pavimento')
            ->get();

        // Definir a estrutura de gabinetes por pavimento
        $gabinetesPorPavimento = [
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

        // Criar estrutura completa com todos os gabinetes
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

        // Agrupar por pavimento
        $vereadoresPorLocalizacao = $vereadoresCompletos->groupBy(function($item) {
            return $item->localization->nome;
        });

        // Ordenar os pavimentos
        $order = [
            '3º PAVIMENTO', '4º PAVIMENTO', '5º PAVIMENTO', '6º PAVIMENTO',
            '7º PAVIMENTO', '8º PAVIMENTO', '9º PAVIMENTO', '10º PAVIMENTO',
            'PALÁCIO'
        ];

        $vereadoresPorLocalizacao = $vereadoresPorLocalizacao->sortBy(function($item, $key) use ($order) {
            return array_search($key, $order);
        });

        // Dividir em grupos de 2 pavimentos por slide
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

        return view('slides.index', [
            'vereadoresGrouped' => $vereadoresGrouped,
            'setoresPorLocalizacao' => $setores->groupBy('localization.nome')
        ]);
    }
    
    public function generateSlides(Request $request)
    {
        $vereadores = Vereadores::with(['partido', 'localization'])
            ->orderBy('pavimento')
            ->get();
    
        $setores = Setores::with('localization')
            ->orderBy('pavimento')
            ->get();

        // Obter dados dos vereadores e setores com os nomes das localizações
        $vereadoresPorLocalizacao = Vereadores::with(['partido', 'localization'])
            ->get()
            ->groupBy(function($item) {
                return $item->localization->nome;
            });
            
        $setoresPorLocalizacao = Setores::with('localization')
            ->get()
            ->groupBy(function($item) {
                return $item->localization->nome;
            });
            
        // Ordenar os grupos de forma específica (opcional)
        $order = [
            '1º PAVIMENTO', '2º PAVIMENTO', '3º PAVIMENTO', '4º PAVIMENTO', 
            '5º PAVIMENTO', '6º PAVIMENTO', '7º PAVIMENTO', '8º PAVIMENTO',
            '9º PAVIMENTO', '10º PAVIMENTO', 'PALÁCIO', 'SUBSOLO'
        ];
        
        $vereadoresPorLocalizacao = $vereadoresPorLocalizacao->sortBy(function($item, $key) use ($order) {
            return array_search($key, $order);
        });
        
        // Dividir em grupos de 2 pavimentos por slide
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
        
        // Se sobrar algum pavimento não agrupado
        if ($tempGroup->count() > 0) {
            $vereadoresGrouped->push($tempGroup);
        }
        
        // Gerar HTML para os slides
        $html = view('slides.template', [
            'vereadoresGrouped' => $vereadoresGrouped,
            'setoresPorLocalizacao' => $setoresPorLocalizacao
        ])->render();
        
        // Opção 2: Gerar PDF
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream('slides-vereadores.pdf');
        
        // Opção 3: Gerar PPT (requer php-office/php-presentation)
        // return $this->generatePowerPoint($vereadoresPorPavimento, $setoresPorPavimento);
    }
    
    protected function generatePowerPoint($vereadoresPorPavimento, $setoresPorPavimento)
    {
        $ppt = new PhpPresentation();
        
        foreach ($vereadoresPorPavimento as $pavimento => $vereadores) {
            $slide = $ppt->createSlide();
            // Configurar layout do slide aqui...
            // Adicionar conteúdo baseado no template
        }
        
        $writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'ppt');
        $writer->save($tempFile);
        
        return response()->download($tempFile, 'slides-vereadores.pptx')->deleteFileAfterSend(true);
    }
}