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
                Nenhum slide adicionado ainda.
            </div>
        </div>

        <!-- Template oculto para clonagem -->
        <template id="slideTemplate" class="">
            <div class="position-relative mb-3">
                <!-- Botão Excluir no canto superior direito -->
                <button type="button" 
                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-remove-slide"
                        title="Excluir">
                    <i class="bi bi-trash"></i>
                </button>
            

                <main class="bg-secondary bg-opacity-25 d-flex flex-column">
                    @include('slides.parts.slide')
                </main>
            </div>
        </template>
    </div>

@endsection