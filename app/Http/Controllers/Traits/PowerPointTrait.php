<?php

namespace App\Http\Controllers\Traits;

trait PowerPointTrait
{
    protected function generatePowerPoint($vereadoresGrouped)
    {
        try {
            $tempDir = $this->createTempDirectory();
            $this->createPPTXStructure($tempDir);
            $this->createContentFiles($tempDir, $vereadoresGrouped);
            
            $zipFile = $this->createZipFile($tempDir);
            $this->cleanUpTempDirectory($tempDir);
            
            return response()->download($zipFile, 'slides-vereadores.pptx')
                ->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function createTempDirectory()
    {
        $tempDir = tempnam(sys_get_temp_dir(), 'pptx_');
        unlink($tempDir);
        mkdir($tempDir);
        return $tempDir;
    }

    private function createPPTXStructure($tempDir)
    {
        if (!class_exists('ZipArchive')) {
            throw new \Exception('ZipArchive não está disponível. Verifique se a extensão ZIP está instalada.');
        }
        
        mkdir($tempDir . '/_rels');
        mkdir($tempDir . '/ppt');
        mkdir($tempDir . '/ppt/_rels');
        mkdir($tempDir . '/ppt/slides');
        mkdir($tempDir . '/ppt/slides/_rels');
        mkdir($tempDir . '/ppt/slideLayouts');
        mkdir($tempDir . '/ppt/slideMasters');
        mkdir($tempDir . '/ppt/theme');
    }

    private function createContentFiles($tempDir, $vereadoresGrouped)
    {
        $this->createContentTypesFile($tempDir);
        $this->createRelsFile($tempDir);
        $this->createPresentationFiles($tempDir, $vereadoresGrouped);
        $this->createSlideFiles($tempDir, $vereadoresGrouped);
    }

    private function createContentTypesFile($tempDir)
    {
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
    }

    private function createRelsFile($tempDir)
    {
        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
            <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="ppt/presentation.xml"/>
        </Relationships>';
        file_put_contents($tempDir . '/_rels/.rels', $rels);
    }

    private function createPresentationFiles($tempDir, $vereadoresGrouped)
    {
        $slideCount = count($vereadoresGrouped);
        
        // presentation.xml
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
        
        // presentation.xml.rels
        $presentationRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
            <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster" Target="slideMasters/slideMaster1.xml"/>
            <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/>';
        
        for ($i = 1; $i <= $slideCount; $i++) {
            $presentationRels .= '<Relationship Id="rId' . ($i + 2) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slide" Target="slides/slide' . $i . '.xml"/>';
        }
        
        $presentationRels .= '</Relationships>';
        file_put_contents($tempDir . '/ppt/_rels/presentation.xml.rels', $presentationRels);
    }

    private function createSlideFiles($tempDir, $vereadoresGrouped)
    {
        foreach ($vereadoresGrouped as $index => $slideGroup) {
            $slideNum = $index + 1;
            $slideContent = $this->generateSlideContent($slideGroup);
            file_put_contents($tempDir . '/ppt/slides/slide' . $slideNum . '.xml', $slideContent);
            
            $slideRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
            </Relationships>';
            file_put_contents($tempDir . '/ppt/slides/_rels/slide' . $slideNum . '.xml.rels', $slideRels);
        }
    }

    private function generateSlideContent($slideGroup)
    {
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
        $yOffset = 2000000;
        $xOffset = 914400;
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
            
            $yOffset += 1200000;
            
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
                
                $yOffset += 2200000;
            }
            
            $xOffset += 4500000;
            $yOffset = 2000000;
        }
        
        $slideContent .= '</p:spTree>
            </p:cSld>
        </p:sld>';
        
        return $slideContent;
    }

    private function createZipFile($tempDir)
    {
        $zipFile = tempnam(sys_get_temp_dir(), 'slides_vereadores_');
        
        $zip = new \ZipArchive();
        $result = $zip->open($zipFile, \ZipArchive::CREATE);
        
        if ($result !== TRUE) {
            throw new \Exception('Erro ao criar arquivo ZIP. Código: ' . $result);
        }
        
        $this->addFolderToZip($zip, $tempDir, '');
        $zip->close();
        
        return $zipFile;
    }

    private function cleanUpTempDirectory($tempDir)
    {
        $this->removeDirectory($tempDir);
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