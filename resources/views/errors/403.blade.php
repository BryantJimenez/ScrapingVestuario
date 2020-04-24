@extends('layouts.error')

@section('title', '403')

@section('content')

<div class="error-body text-center">
	<h1>403</h1>
	<h3 class="text-uppercase">Error de Prohibición!</h3>
	<p class="text-muted m-t-30 m-b-30">NO TIENES PERMISO PARA ACCEDER A ESTE SITIO.</p>
	<a href="{{ route('home') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Volver al Inicio</a>
</div>

@endsection