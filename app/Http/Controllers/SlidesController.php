<?php

namespace App\Http\Controllers;

use App\Models\Vereadores;
use App\Models\Setores;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Para geração de PDF
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Border;
// ZipArchive é uma classe nativa do PHP, não precisa de import
// RecursiveIteratorIterator e RecursiveDirectoryIterator também são nativos

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
        $format = $request->get('format', 'html');
        
        // Obter dados dos vereadores
        $vereadores = Vereadores::with(['partido', 'localization'])
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
        
        // Gerar baseado no formato solicitado
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
    
    protected function generatePowerPoint($vereadoresGrouped)
    {
        try {
            // Verificar se ZipArchive está disponível
            if (!class_exists('ZipArchive')) {
                throw new \Exception('ZipArchive não está disponível. Verifique se a extensão ZIP está instalada.');
            }
            
            // Criar diretório temporário para o PPTX
            $tempDir = tempnam(sys_get_temp_dir(), 'pptx_');
            unlink($tempDir);
            mkdir($tempDir);
        
        // Criar estrutura de diretórios do PPTX
        mkdir($tempDir . '/_rels');
        mkdir($tempDir . '/ppt');
        mkdir($tempDir . '/ppt/_rels');
        mkdir($tempDir . '/ppt/slides');
        mkdir($tempDir . '/ppt/slides/_rels');
        mkdir($tempDir . '/ppt/slideLayouts');
        mkdir($tempDir . '/ppt/slideMasters');
        mkdir($tempDir . '/ppt/theme');
        
        // Criar arquivo [Content_Types].xml
        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/ppt/presentation.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.presentation.main+xml"/>
    <Override PartName="/ppt/slideMasters/slideMaster1.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.slideMaster+xml"/>
    <Override PartName="/ppt/slides/slide1.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.slide+xml"/>
    <Override PartName="/ppt/theme/theme1.xml" ContentType="application/vnd.openxmlformats-officedocument.theme+xml"/>
</Types>';
        file_put_contents($tempDir . '/[Content_Types].xml', $contentTypes);
        
        // Criar arquivo _rels/.rels
        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="ppt/presentation.xml"/>
</Relationships>';
        file_put_contents($tempDir . '/_rels/.rels', $rels);
        
        // Criar arquivo ppt/presentation.xml
        $slideCount = count($vereadoresGrouped);
        $presentation = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:presentation xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main">
    <p:sldMasterIdLst>
        <p:sldMasterId id="2147483648" r:id="rId1"/>
    </p:sldMasterIdLst>
    <p:sldIdLst>';
        
        for ($i = 1; $i <= $slideCount; $i++) {
            $presentation .= '<p:sldId id="' . (256 + $i) . '" r:id="rId' . ($i + 1) . '"/>';
        }
        
        $presentation .= '</p:sldIdLst>
</p:presentation>';
        file_put_contents($tempDir . '/ppt/presentation.xml', $presentation);
        
        // Criar arquivo ppt/_rels/presentation.xml.rels
        $presentationRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster" Target="slideMasters/slideMaster1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/>';
        
        for ($i = 1; $i <= $slideCount; $i++) {
            $presentationRels .= '<Relationship Id="rId' . ($i + 2) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slide" Target="slides/slide' . $i . '.xml"/>';
        }
        
        $presentationRels .= '</Relationships>';
        file_put_contents($tempDir . '/ppt/_rels/presentation.xml.rels', $presentationRels);
        
        // Criar slides
        foreach ($vereadoresGrouped as $index => $slideGroup) {
            $slideNum = $index + 1;
            
            // Criar conteúdo do slide
            $slideContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:sld xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main">
    <p:cSld>
        <p:spTree>
            <p:nvGrpSpPr>
                <p:cNvPr id="1" name=""/>
                <p:cNvGrpSpPr/>
                <p:nvPr/>
            </p:nvGrpSpPr>
            <p:grpSpPr>
                <a:xfrm>
                    <a:off x="0" y="0"/>
                    <a:ext cx="0" cy="0"/>
                    <a:chOff x="0" y="0"/>
                    <a:chExt cx="0" cy="0"/>
                </a:xfrm>
            </p:grpSpPr>';
            
            // Adicionar título
            $slideContent .= '<p:sp>
                <p:nvSpPr>
                    <p:cNvPr id="2" name="Title"/>
                    <p:cNvSpPr/>
                    <p:nvPr>
                        <p:ph type="title"/>
                    </p:nvPr>
                </p:nvSpPr>
                <p:spPr>
                    <a:xfrm>
                        <a:off x="914400" y="457200"/>
                        <a:ext cx="8236800" cy="1371600"/>
                    </a:xfrm>
                </p:spPr>
                <p:txBody>
                    <a:bodyPr/>
                    <a:lstStyle/>
                    <a:p>
                        <a:r>
                            <a:rPr lang="pt-BR" sz="3200" b="1">
                                <a:solidFill>
                                    <a:srgbClr val="FFFFFF"/>
                                </a:solidFill>
                            </a:rPr>
                            <a:t>EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)</a:t>
                        </a:r>
                    </a:p>
                </p:txBody>
            </p:sp>';
            
            // Adicionar conteúdo dos vereadores
            $yOffset = 2000000; // 2cm em EMUs
            $xOffset = 914400; // 1cm em EMUs
            $shapeId = 3;
            
            foreach ($slideGroup as $localizacao => $vereadores) {
                // Título da localização
                $slideContent .= '<p:sp>
                    <p:nvSpPr>
                        <p:cNvPr id="' . $shapeId++ . '" name="Localizacao"/>
                        <p:cNvSpPr/>
                        <p:nvPr/>
                    </p:nvSpPr>
                    <p:spPr>
                        <a:xfrm>
                            <a:off x="' . $xOffset . '" y="' . $yOffset . '"/>
                            <a:ext cx="4000000" cy="800000"/>
                        </a:xfrm>
                    </p:spPr>
                    <p:txBody>
                        <a:bodyPr/>
                        <a:lstStyle/>
                        <a:p>
                            <a:r>
                                <a:rPr lang="pt-BR" sz="2000" b="1">
                                    <a:solidFill>
                                        <a:srgbClr val="333333"/>
                                    </a:solidFill>
                                </a:rPr>
                                <a:t>' . htmlspecialchars($localizacao) . '</a:t>
                            </a:r>
                        </a:p>
                    </p:txBody>
                </p:sp>';
                
                $yOffset += 1200000; // 1.2cm
                
                // Vereadores
                foreach ($vereadores as $vereador) {
                    $text = $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico;
                    $text .= "\n" . strtoupper($vereador->titulo);
                    
                    if (isset($vereador->partido->nome) && $vereador->partido->nome != 'Sem partido') {
                        $text .= "\n" . $vereador->partido->nome;
                    }
                    
                    $text .= "\nGAB. " . $vereador->sala;
                    
                    $slideContent .= '<p:sp>
                        <p:nvSpPr>
                            <p:cNvPr id="' . $shapeId++ . '" name="Vereador"/>
                            <p:cNvSpPr/>
                            <p:nvPr/>
                        </p:nvSpPr>
                        <p:spPr>
                            <a:xfrm>
                                <a:off x="' . $xOffset . '" y="' . $yOffset . '"/>
                                <a:ext cx="4000000" cy="2000000"/>
                            </a:xfrm>
                            <a:prstGeom prst="rect"/>
                            <a:solidFill>
                                <a:srgbClr val="F8F9FA"/>
                            </a:solidFill>
                            <a:ln w="12700">
                                <a:solidFill>
                                    <a:srgbClr val="CCCCCC"/>
                                </a:solidFill>
                            </a:ln>
                        </p:spPr>
                        <p:txBody>
                            <a:bodyPr/>
                            <a:lstStyle/>
                            <a:p>
                                <a:r>
                                    <a:rPr lang="pt-BR" sz="1600">
                                        <a:solidFill>
                                            <a:srgbClr val="333333"/>
                                        </a:solidFill>
                                    </a:rPr>
                                    <a:t>' . htmlspecialchars($text) . '</a:t>
                                </a:r>
                            </a:p>
                        </p:txBody>
                    </p:sp>';
                    
                    $yOffset += 2200000; // 2.2cm
                }
                
                $xOffset += 4500000; // 4.5cm para próxima coluna
                $yOffset = 2000000; // Reset Y para próxima coluna
            }
            
            $slideContent .= '</p:spTree>
    </p:cSld>
</p:sld>';
            
            file_put_contents($tempDir . '/ppt/slides/slide' . $slideNum . '.xml', $slideContent);
            
            // Criar arquivo de relacionamentos do slide
            $slideRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
</Relationships>';
            file_put_contents($tempDir . '/ppt/slides/_rels/slide' . $slideNum . '.xml.rels', $slideRels);
        }
        
        // Criar arquivo ZIP (PPTX)
        $zipFile = tempnam(sys_get_temp_dir(), 'slides_vereadores_');
        
        // Verificar se ZipArchive está disponível
        if (!class_exists('ZipArchive')) {
            throw new \Exception('ZipArchive não está disponível. Verifique se a extensão ZIP está instalada.');
        }
        
        $zip = new \ZipArchive();
        $result = $zip->open($zipFile, \ZipArchive::CREATE);
        
        if ($result !== TRUE) {
            throw new \Exception('Erro ao criar arquivo ZIP. Código: ' . $result);
        }
        
        // Adicionar todos os arquivos ao ZIP
        $this->addFolderToZip($zip, $tempDir, '');
        $zip->close();
        
        // Limpar diretório temporário
        $this->removeDirectory($tempDir);
        
        // Retornar download do arquivo
        return response()->download($zipFile, 'slides-vereadores.pptx')->deleteFileAfterSend(true);
        
        } catch (\Exception $e) {
            // Em caso de erro, retornar uma resposta de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    private function addFolderToZip($zip, $folder, $relativePath)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativeFilePath = $relativePath . substr($filePath, strlen($folder) + 1);
                $zip->addFile($filePath, $relativeFilePath);
            }
        }
    }
    
    private function removeDirectory($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->removeDirectory($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}