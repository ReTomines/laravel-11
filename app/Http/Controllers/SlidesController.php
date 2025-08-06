<?php

namespace App\Http\Controllers;

use App\Models\{Vereadores, Setores};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Traits\{VereadoresTrait, PowerPointTrait};
use Illuminate\Support\Facades\Storage;

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
    
    public function saveImages(Request $request)
    {
        try {
            $imagesData = json_decode($request->input('images'), true);
            
            if (empty($imagesData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhuma imagem foi enviada.'
                ]);
            }
            
            // Criar diretório para as imagens se não existir
            $directory = 'slides/' . date('Y-m-d_H-i-s');
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $savedFiles = [];
            
            foreach ($imagesData as $imageData) {
                $dataUrl = $imageData['dataUrl'];
                $filename = $imageData['name'];
                
                // Extrair os dados da imagem da URL de dados
                list($type, $data) = explode(';', $dataUrl);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                
                // Salvar a imagem no storage
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $data);
                
                $savedFiles[] = $path;
            }
            
            return response()->json([
                'success' => true,
                'message' => count($savedFiles) . ' imagens foram salvas com sucesso no diretório: ' . $directory,
                'files' => $savedFiles
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar as imagens: ' . $e->getMessage()
            ]);
        }
    }
}