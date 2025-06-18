@php
    $activeTab = session('active_tab', 'vereadores'); // "vereadores" como padrão
@endphp

@extends('layouts.default')
@section('page-title', 'Cadastrar Dados')

@section('page-actions')

    @php
        $activeTab = session('active_tab', request('tab', 'vereadores')); 
    @endphp

    <a href="#" id="btnAdicionar" class="btn btn-primary btn-sm">Adicionar</a>

@endsection

@section('content')

    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession
    
    <form 
        action="{{ route('users.index') }}" 
        method="GET"
        class="mb-3"
        style="width: 300px">
        <div class="input-group input-group-sm">
            <input 
                type="text"
                name="keyword"
                class="form-control"
                value=""
                placeholder="Pesquise por nome ou email...">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
    </form>


<!-- Exibição -->
<div class="card">

    <div class="card-header">
        <ul class="nav nav-pills card-header-pills">

            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'vereadores' ? 'active' : '' }}" id="vereadores-tab" data-bs-toggle="tab" href="#vereadores" role="tab" aria-controls="vereadores" aria-selected="true">Vereadores</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'setores' ? 'active' : '' }}" id="setores-tab" data-bs-toggle="tab" href="#setores" role="tab" aria-controls="setores" aria-selected="false">Setores</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'partidos' ? 'active' : '' }}" id="partidos-tab" data-bs-toggle="tab" href="#partidos" role="tab" aria-controls="partidos" aria-selected="false">Partidos</a>
            </li>

        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="nav-tabContent">
            
            <div class="tab-pane fade {{ $activeTab == 'vereadores' ? 'show active' : '' }}" id="vereadores" role="tabpanel" aria-labelledby="vereadores-tab">
                @include('videowall.parts-index.ind-vereadores')
            </div>

            <div class="tab-pane fade {{ $activeTab == 'setores' ? 'show active' : '' }}" id="setores" role="tabpanel" aria-labelledby="setores-tab">
                @include('videowall.parts-index.ind-setores')
            </div>

            <div class="tab-pane fade {{ $activeTab == 'partidos' ? 'show active' : '' }}" id="partidos" role="tabpanel" aria-labelledby="partidos-tab">
                @include('videowall.parts-index.ind-partidos')
            </div>
        
        </div>
    </div>

</div>

@endsection