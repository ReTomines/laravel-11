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
        // Obter dados dos vereadores e setores agrupados por pavimento
        $vereadoresPorPavimento = Vereadores::with(['partido', 'localization'])
            ->orderBy('pavimento')
            ->orderBy('sala')
            ->get()
            ->groupBy('pavimento');
            
        $setoresPorPavimento = Setores::with('localization')
            ->orderBy('pavimento')
            ->orderBy('sala')
            ->get()
            ->groupBy('pavimento');
            
        // Gerar HTML para os slides
        $html = view('slides.template', compact('vereadoresPorPavimento', 'setoresPorPavimento'))->render();
        
        // Opção 1: Retornar como HTML (para exibição no navegador)
        if ($request->input('format') === 'html') {
            return $html;
        }
        
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