@extends('layouts.default')
@section('page-title', 'Slides')

@section('content')
    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession

    <!-- Área para exibir mensagens de sucesso ou erro -->
    <div id="message-area" class="alert" style="display: none;"></div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gerar Slides</h3>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <a href="{{ route('slides.generate', ['format' => 'pdf']) }}" class="btn btn-danger me-2" target="_blank">
                        <i class="fas fa-file-pdf"></i> Baixar PDF
                    </a>
                    <a href="{{ route('slides.generate', ['format' => 'pptx']) }}" class="btn btn-primary me-2">
                        <i class="fas fa-file-powerpoint"></i> Baixar PPTX
                    </a>
                    <button id="generateImages" class="btn btn-success">
                        <i class="fas fa-image"></i> Gerar Imagens
                    </button>
                </div>
            </div>
            
            <div id="preview-container" class="bg-light p-3" style="min-height: 500px; border: 1px dashed #ccc;">
                
                @if(isset($vereadoresGrouped) && $vereadoresGrouped->count() > 0)
                    @foreach($vereadoresGrouped as $index => $slideGroup)
                        <div class="slide-container" data-slide-index="{{ $index }}" style="margin-bottom: 40px; border: 1px solid #999; padding: 15px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="m-0">Slide {{ $index + 1 }}</h5>
                            </div>
                            <div class="slide-content">
                                <h4 style="text-align: center; background: #333; color: white; padding: 10px;">
                                    EDIFÍCIO GENERAL EURICO GASPAR DUTRA (EDIFÍCIO ANEXO)
                                </h4>
                                
                                <div style="display: flex; gap: 20px;">
                                    @foreach($slideGroup as $localizacao => $vereadores)
                                        <div style="flex: 1;">
                                            <h5 class="localizacao-title">{{ $localizacao }}</h5>
                                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                                @foreach($vereadores as $vereador)
                                                    <div style="border: 1px solid #ddd; padding: 15px; display: flex; align-items: center; gap: 20px; position: relative; height: 130px;">
                                                        @if($vereador->nome_politico == 'VAGO')
                                                            <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #eee; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; color: #999; font-size: 14px;">
                                                                <span>VAGO</span>
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('storage/' . $vereador->foto_ver) }}" 
                                                                alt="{{ $vereador->nome_politico }}" 
                                                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;"
                                                                onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                                        @endif
                                                        
                                                        <div style="flex: 1;">
                                                            <div style="font-weight: bold; font-size: 13px; color: #555;">{{ strtoupper($vereador->titulo) }}</div>
                                                            <div style="font-weight: bold; font-size: 16px;">{{ $vereador->nome_politico == 'VAGO' ? 'VAGO' : $vereador->nome_politico }}</div>
                                                            
                                                            @if(isset($vereador->partido->nome) && $vereador->partido->nome != 'Sem partido')
                                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                                                                @if(isset($vereador->partido->logo))
                                                                    <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                                                        alt="{{ $vereador->partido->nome }}" 
                                                                        style="width: 76px; height: 76px; object-fit: contain;"
                                                                        onerror="this.style.display='none'">
                                                                @endif
                                                                <span>{{ $vereador->partido->nome }}</span>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div style="position: absolute; right: 15px; display: flex; align-items: center; gap: 8px; font-size: 16px; color: #777;">
                                                            @if(isset($vereador->partido->logo) && $vereador->nome_politico != 'VAGO')
                                                                <img src="{{ asset('storage/' . $vereador->partido->logo) }}" 
                                                                    alt="{{ $vereador->partido->nome }}" 
                                                                    style="width: 60px; height: 60px; object-fit: contain;"
                                                                    onerror="this.style.display='none'">
                                                            @endif
                                                            <span>GAB. {{ $vereador->sala }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-5">
                        Nenhum vereador cadastrado.
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Formulário oculto para enviar as imagens -->
    <form id="imageForm" action="{{ route('slides.saveImages') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="images" id="imagesInput">
    </form>

    @push('scripts')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const generateImagesBtn = document.getElementById('generateImages');
            const messageArea = document.getElementById('message-area');
            const imageForm = document.getElementById('imageForm');
            const imagesInput = document.getElementById('imagesInput');
            
            function showMessage(message, type) {
                messageArea.textContent = message;
                messageArea.className = 'alert alert-' + type;
                messageArea.style.display = 'block';
                
                // Rolar para o topo para mostrar a mensagem
                window.scrollTo(0, 0);
                
                // Esconder a mensagem após 5 segundos
                setTimeout(() => {
                    messageArea.style.display = 'none';
                }, 5000);
            }
            
            generateImagesBtn.addEventListener('click', async function() {
                // Desabilitar o botão durante o processamento
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
                
                try {
                    const slideContainers = document.querySelectorAll('.slide-container');
                    
                    if (slideContainers.length === 0) {
                        showMessage('Nenhum slide disponível para captura.', 'warning');
                        return;
                    }
                    
                    const imagesData = [];
                    
                    for (let i = 0; i < slideContainers.length; i++) {
                        const slideIndex = parseInt(slideContainers[i].getAttribute('data-slide-index'));
                        const slideContent = slideContainers[i].querySelector('.slide-content');
                        
                        // Mostrar progresso
                        this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Processando slide ${i+1} de ${slideContainers.length}...`;
                        
                        const canvas = await html2canvas(slideContent, {
                            scale: 2, // Melhor qualidade
                            useCORS: true, // Permitir imagens de outros domínios
                            logging: false,
                            backgroundColor: '#ffffff'
                        });
                        
                        // Adicionar a imagem ao array
                        const imageData = {
                            dataUrl: canvas.toDataURL('image/png'),
                            name: `slide-${slideIndex + 1}.png`
                        };
                        
                        imagesData.push(imageData);
                    }
                    
                    // Enviar as imagens para o servidor
                    imagesInput.value = JSON.stringify(imagesData);
                    
                    // Enviar o formulário
                    const formData = new FormData(imageForm);
                    
                    const response = await fetch(imageForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        showMessage(result.message, 'success');
                    } else {
                        showMessage(result.message, 'danger');
                    }
                    
                } catch (error) {
                    console.error('Erro ao capturar os slides:', error);
                    showMessage('Ocorreu um erro ao gerar as imagens dos slides.', 'danger');
                } finally {
                    // Reativar o botão
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-image"></i> Gerar Imagens';
                }
            });
        });
    </script>
    @endpush
@endsection