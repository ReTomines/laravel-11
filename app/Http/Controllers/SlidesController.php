<?php

namespace App\Http\Controllers;

use App\Models\{Vereadores, Setores};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Traits\{VereadoresTrait, PowerPointTrait};

class SlidesController extends Controller
{
    use VereadoresTrait, PowerPointTrait;

    public function index()
    {
        $vereadores = $this->getVereadoresOrdenados();
        $setores = $this->getSetoresOrdenados();
        
        $vereadoresCompletos = $this->criarEstruturaCompletaVereadores($vereadores);
        $vereadoresPorLocalizacao = $this->agruparVereadoresPorLocalizacao($vereadoresCompletos);
        $vereadoresGrouped = $this->agruparParaSlides($vereadoresPorLocalizacao);

        return view('slides.index', [
            'vereadoresGrouped' => $vereadoresGrouped,
            'setoresPorLocalizacao' => $setores->groupBy('localization.nome')
        ]);
    }
    
    public function generateSlides(Request $request)
    {
        $format = $request->get('format', 'html');
        
        $vereadores = $this->getVereadoresOrdenados();
        $vereadoresCompletos = $this->criarEstruturaCompletaVereadores($vereadores);
        $vereadoresPorLocalizacao = $this->agruparVereadoresPorLocalizacao($vereadoresCompletos);
        $vereadoresGrouped = $this->agruparParaSlides($vereadoresPorLocalizacao);
        
        switch ($format) {
            case 'pdf':
                $html = view('slides.template', [
                    'vereadoresGrouped' => $vereadoresGrouped
                ])->render();
                $pdf = Pdf::loadHTML($html);
                return $pdf->stream('slides-vereadores.pdf');
                
            case 'pptx':
                return $this->generatePowerPoint($vereadoresGrouped);
                
            case 'html':
            default:
                return view('slides.template', [
                    'vereadoresGrouped' => $vereadoresGrouped
                ]);
        }
    }
}