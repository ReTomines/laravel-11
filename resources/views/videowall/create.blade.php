@extends('layouts.default')
@section('page-title', 'Incluir dados')
@section('content')

<div class="card">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
      <a class="nav-link active" id="vereadores-tab" data-bs-toggle="tab" href="#vereadores" role="tab" aria-controls="vereadores" aria-selected="true">Vereadores</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" id="setores-tab" data-bs-toggle="tab" href="#setores" role="tab" aria-controls="setores" aria-selected="false">Setores</a>
      </li>
    </ul>
  </div>
  
  <div class="card-body">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="vereadores" role="tabpanel" aria-labelledby="vereadores-tab">
        @include('videowall.parts.vereadores')
      </div>
      <div class="tab-pane fade" id="setores" role="tabpanel" aria-labelledby="setores-tab">
        @include('videowall.parts.setores')
      </div>
    </div>
  </div>
</div>

@endsection