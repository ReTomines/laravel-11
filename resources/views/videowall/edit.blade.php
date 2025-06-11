@extends('layouts.default')
@section('page-title', 'Editar Usuário')
@section('content')

    @session('status')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession

    @include('videowall.parts-edit.edit-partidos') <br>

@endsection