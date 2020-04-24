@extends('layouts.web')

@section('title', 'Inicio')

@section('content')

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 ftco-animate">
				<form action="#" method="POST">
					@csrf
					<div class="row align-items-end">
						<div class="col-12">
							<div class="cart-detail cart-total p-3 p-md-4 bg-white">
								<p class="h4 text-center mt-2">Presiona el boton para empezar a extraer los datos</p>
								<div class="row">
									<div class="col-12">
										<div class="form-group text-center">
											<button class="btn btn-primary" type="submit">Empezar</button>
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