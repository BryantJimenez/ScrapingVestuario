@extends('layouts.web')

@section('title', 'Inicio')

@section('content')

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 ftco-animate">
				<form action="{{ route('scraping') }}" method="POST">
					@csrf
					<div class="row align-items-end">
						<div class="col-12">
							<div class="cart-detail cart-total p-3 p-md-4 bg-white">
								<p class="h4 text-center mt-2">Usa el buscador y luego presiona el boton para extraer los datos.</p>
								<div class="row">
									<div class="col-4">
										<div class="form-group">
											<label class="form-label">Categoría</label>
											<select class="form-control" required name="category">
												<option value="">Seleccione</option>
												@foreach($categories as $category)
												<option value="{{ $category['link'] }}" category="{{ $category['category'] }}" withFilters="{{ $category['withFilters'] }}" withSubcategories="{{ $category['withSubcategories'] }}">{{ $category['category'] }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-4">
										<div class="form-group">
											<label class="form-label">Filtro</label>
											<select class="form-control" required name="filter" disabled>
												<option value="">Seleccione</option>
												@foreach($categories as $category)
												@if($category['withFilters'])

												@foreach($category['filters'] as $filter)
												<option class="d-none" value="{{ $filter['filter'] }}" category="{{ $category['category'] }}">{{ $filter['filter'] }}</option>
												@endforeach

												@endif
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-4">
										<div class="form-group">
											<label class="form-label">Subcategoría</label>
											<select class="form-control" required name="subcategory" disabled>
												<option value="">Seleccione</option>
												@foreach($categories as $category)
												@if($category['withFilters'])

												@foreach($category['filters'] as $filter)
												@foreach($filter['subcategories'] as $subcategory)
												<option class="d-none" value="{{ $subcategory['link'] }}" filter="{{ $filter['filter'] }}" category="{{ $category['category'] }}">{{ $subcategory['subcategory'] }}</option>
												@endforeach
												@endforeach
												
												@else
												@if($category['withSubcategories'])

												@foreach($category['subcategories'] as $subcategory)
												<option class="d-none" value="{{ $subcategory['link'] }}" category="{{ $category['category'] }}">{{ $subcategory['subcategory'] }}</option>
												@endforeach

												@endif
												@endif
												
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-12 d-none" id="alert">
										<div class="alert alert-info">
											<ul>
												<li id="message-info"></li>
											</ul>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group text-center">
											<button class="btn btn-primary" type="submit" disabled id="btn-extract">Extraer Datos</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@endsection