@extends('layouts.default')

    <!-- Títulos -->
    @section('page-title')
        @if (isset($vereador))
            Criar Vereador
        @elseif (isset($setor))
            Criar Setor
        @elseif (isset($partido))
            Criar Partido
        @endif
    @endsection

@section('content')

    <!-- Mensagens -->
    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession

    {{-- DEBUG opcional --}}
    {{-- <h3>Aba ativa: {{ $activeTab }}</h3> --}}
    
    <!-- Formulários -->
    @if ($activeTab === 'vereadores')
        @include('videowall.parts.vereadores')
    @elseif ($activeTab === 'setores')
        @include('videowall.parts.setores')
    @elseif ($activeTab === 'partidos')
        @include('videowall.parts.partidos')
    @endif

@endsection