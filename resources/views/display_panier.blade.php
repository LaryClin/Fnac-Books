@extends('layouts.app')

@section('content')

<div class="container">
	@if (count($livres) > 0)
	<table class="table">
		<thead>
			<tr>
				<th scope="col" class="col-xs-5">Titre</th>
				<th scope="col" class="col-xs-1">Quantité</th>
				<th scope="col" class="col-xs-2">Prix unitaire</th>
				<th scope="col" class="col-xs-2">Prix total</th>
				<th scope="col" class="col-xs-2">Supprimer</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($livres as $l)
			<tr class="panier_item" data-liv_id="{{ $l->liv_id }}">
				<td><a href="{{ url('consulter')}}/{{ $l->liv_id }}">{{ $l->liv_titre }}</a></td>
				<td>
					<input data-liv_id="{{ $l->liv_id }}" data-previous="{{ $l->attributes['qte'] }}" class="form-control item_number_input" type="number" min="1" value="{{ $l->attributes['qte'] }}">
				</td>
				<td><span class="liv_prix_unitaire" data-liv_id="{{ $l->liv_id }}">{{ $l->liv_prixttc }}</span>€</td>
				<td><span class="liv_prix_total" data-liv_id="{{ $l->liv_id }}">{{ $l->liv_prixttc * $l->attributes['qte'] }}</span>€</td>
				<td>
					<button class="btn btn-danger delete_item_panier" data-liv_id="{{ $l->liv_id }}">Supprimer</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row" align="right">
		<div class="col">
			<h3>Total : <span id="total_price">{{ $total_price }}</span>€</h3>
		</div>
		<div class="col">
			@if(Auth::check())
			<a href="{{ url('/commande/confirmation') }}" class="btn btn-primary">Commander</a>
			@else
			<a href="{{ url('/panier/sessionToDb') }}" class="btn btn-primary">Commander</a>
			@endif
		</div>
	</div>
	@else
	<h2>Votre panier est vide</h2>
	@endif
</div>

@endsection

@section('custom_js')
<script type="text/javascript">
	let base_url = "{{ url('/') }}";
</script>
<script src="{{ URL::asset('js/view_panier.js') }}"></script>
@endsection