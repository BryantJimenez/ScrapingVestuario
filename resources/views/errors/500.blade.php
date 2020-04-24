@extends('layouts.error')

@section('title', '500')

@section('content')

<div class="error-body text-center">
	<h1>500</h1>
	<h3 class="text-uppercase">Error Interno en el Servidor !</h3>
	<p class="text-muted m-t-30 m-b-30">POR FAVOR INTENTELO MÁS TARDE</p>
	<a href="{{ route('home') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Volver al Inicio</a>
</div>

@endsection