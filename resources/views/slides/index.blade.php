@extends('layouts.default')
@section('page-title', 'Slides')

@section('page-actions')

    <a href="#" id="btnAddSlide" class="btn btn-primary btn-sm">Adicionar</a>

@endsection

@section('content')

    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession
    

    <!-- Exibição -->
    <div class="card">

        <div class="card bg-secondary bg-opacity-25" id="containerSlides" style="min-height: 715px;">
            <div id="placeholderSlide" class="text-muted text-center py-5">
                
                    <button id="generateSlides" class="btn btn-primary">
                        <i class="fas fa-images"></i> Gerar Slides
                    </button>
                    <button id="generateVideo" class="btn btn-success">
                        <i class="fas fa-video"></i> Gerar Vídeo
                    </button>
                    <a href="{{ asset('storage/videos/videowall_output.mp4') }}" id="downloadVideo" class="btn btn-info" style="display:none;">
                        <i class="fas fa-download"></i> Baixar Vídeo
                    </a>

            </div>
        </div>

    </div>

@endsection