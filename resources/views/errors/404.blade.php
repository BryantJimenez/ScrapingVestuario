@extends('layouts.error')

@section('title', '404')

@section('content')

<div class="error-body text-center">
	<h1>404</h1>
	<h3 class="text-uppercase">Página No Encontrada !</h3>
	<p class="text-muted m-t-30 m-b-30">LO QUE ESTAS BUSCANDO NO LO ENCONTRARAS AQUÍ</p>
	<a href="{{ route('home') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Volver al Inicio</a>
</div>

@endsection