@extends('layouts.default')
@section('page-title', 'VideoWall')

@section('page-actions')
    <a href="{{ route('videowall.create') }}" class="btn btn-primary btn-sm">Adicionar</a>
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

    <table class="table">

    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Vereador</th>
        <th scope="col">Partido</th>
        <th scope="col">Sala</th>
        <th scope="col">Ação</th>

        </tr>
    </thead>
    <tbody>
    @foreach ($vereadores as $vereador)
        <tr>
            <th scope="row">{{ $vereador->id }}</th>
            <td>{{ $vereador->nome_politico }}</td>
            <td>
                <img src="{{ asset('storage/' . $vereador->logo_partido) }}">
            </td>
            <td>{{ $vereador->sala }}</td>
            <td>
            
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection