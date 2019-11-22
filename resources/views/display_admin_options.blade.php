@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Espace administrateur</div>
		<div class="panel-body">
			@if (Auth::user()->isAdmin())
			<div class="row">
				<div class="col-xs-12">
					<a role="button" class="btn btn-primary" href="{{ route('admin_moderate') }}">Gérer les permissions</a>
				</div>
			</div>
			@endif
			@if (Auth::user()->isAdmin() or Auth::user()->isCommunicationService())
			<div class="row">
				<div class="col-xs-12">
					<h3>Service communication</h3>
					<a role="button" class="btn btn-primary" href="{{ route('avis-abusif') }}">Gérer les avis</a>
				</div>
			</div>
			@endif 
			@if (Auth::user()->isAdmin() or Auth::user()->isSaleService())
			<div class="row">
				<div class="col-xs-12">
					<h3>Service vente</h3>
					<a role="button" class="btn btn-primary" href="{{ route('genre') }}">Gérer les genres</a>
					<a role="button" class="btn btn-primary" href="{{ route('photos') }}">Gérer les photos</a>
				</div>
			</div>
			@endif
			@if (Auth::user()->isAdmin() or Auth::user()->isCustomerService())
			<div class="row">
				<div class="col-xs-12">
					<h3>Service adhérent</h3>
					<a role="button" class="btn btn-primary" href="{{ route('commande') }}">Consulter commandes</a>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection