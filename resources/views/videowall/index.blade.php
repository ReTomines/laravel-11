@extends('layouts.default')
@section('page_title', 'Videowall')

@section('page-actions')
    <a href="{{ route('videowall.create') }}" class="btn btn-primary btn-sm">Adicionar</a>
@endsection

@section('content')
    Videowall

@endsection