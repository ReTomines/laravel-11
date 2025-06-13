@extends('layouts.default')

    <!-- Títulos -->
    @if (isset($vereador))
        @section('page-title', 'Editar Vereador')
    @elseif (isset($setor))
        @section('page-title', 'Editar Setor')
    @elseif (isset($partido))
        @section('page-title', 'Editar Partido')
    @endif

@section('content')

    <!-- Mensagens -->
    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession
    
    <!--pre>
        {-- debug --}
        Setor: {{ isset($setor) ? 'ok' : 'vazio' }}
        Partido: {{ isset($partido) ? 'ok' : 'vazio' }}
        Vereador: {{ isset($vereador) ? 'ok' : 'vazio' }}
    </pre-->

    <!-- Formulários -->
    @if (isset($vereador))
        @include('videowall.parts-edit.edit-vereadores')

    @elseif (isset($setor))
        @include('videowall.parts-edit.edit-setores')

    @elseif (isset($partido))
        @include('videowall.parts-edit.edit-partidos')
    @endif

@endsection