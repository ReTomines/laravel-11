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
        $vereadores = Vereadores::with(['partido', 'localization'])->get();
        $setores = Setores::with('localization')->get();
        
        return view('slides.index', compact('vereadores', 'setores'));
    }
    
    public function generateSlides(Request $request)
    {
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
        
        $setoresPorLocalizacao = $setoresPorLocalizacao->sortBy(function($item, $key) use ($order) {
            return array_search($key, $order);
        });
        
        // Gerar HTML para os slides
        $html = view('slides.template', compact('vereadoresPorLocalizacao', 'setoresPorLocalizacao'))->render();
        
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