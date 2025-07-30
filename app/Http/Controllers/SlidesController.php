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
        $vereadores = Vereadores::with(['partido', 'localization'])
            ->orderBy('pavimento')
            ->orderBy('sala')
            ->get();
        
        $setores = Setores::with('localization')
            ->orderBy('pavimento')
            ->get();
        
        // Agrupar por pavimento e ordenar
        $vereadoresPorLocalizacao = $vereadores->groupBy(function($item) {
            return $item->localization->nome;
        });
        
        $setoresPorLocalizacao = $setores->groupBy(function($item) {
            return $item->localization->nome;
        });
        
        // Ordenar os pavimentos (exceto Palácio)
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
        
        // Se sobrar algum pavimento não agrupado
        if ($tempGroup->count() > 0) {
            $vereadoresGrouped->push($tempGroup);
        }
        
        return view('slides.index', [
            'vereadoresGrouped' => $vereadoresGrouped,
            'setoresPorLocalizacao' => $setoresPorLocalizacao
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