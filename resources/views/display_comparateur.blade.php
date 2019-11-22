@extends('layouts.app')

@section('content')

<div class="container">
	<!--
	<div class="row">
		
		<h2>Comparateur de livres</h2>
		@forelse($livres as $livre)
		<div class="col-sm-4">
			<h3 class="comparator_title">{{ $livre->liv_titre }}</h3>
			<p class="comparator_description">{{ $livre->liv_histoire }}</p>
			<p class="comparator_date">{{ $livre->liv_dateparution }}</p>
			<p class="comparator_price">{{ $livre->liv_prixttc }}</p>
			<p class="comparator_stock">{{ $livre->liv_stock }}</p>
		</div>
		@empty
		<h3>Aucun livre dans le comparateur</h3>
		@endforelse
	</div>
	-->

	@if (count($livres) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Critère</th>
				@foreach($livres as $livre)
				<th data-id="{{ $livre->liv_id }}">{{ $livre->liv_titre }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>Date de parution</th>
				@foreach($livres as $livre)
				<td data-id="{{ $livre->liv_id }}">{{ $livre->liv_dateparution }}</td>
				@endforeach
			</tr>
			<tr>
				<th>Prix TTC</th>
				@foreach($livres as $livre)
				<td data-id="{{ $livre->liv_id }}">{{ $livre->liv_prixttc }}€</td>
				@endforeach
			</tr>
			<tr>
				<th>Stock</th>
				@foreach($livres as $livre)
				<td data-id="{{ $livre->liv_id }}">{{ $livre->liv_stock }} disponible(s)</td>
				@endforeach
			</tr>
			<tr>
				<th>Suppression</th>
				@foreach($livres as $livre)
				<td data-id="{{ $livre->liv_id }}">
					<button class="btn btn-danger del_livre" data-id="{{ $livre->liv_id }}">Supprimer du comparateur</button>
				</td>
				@endforeach
			</tr>
		</tbody>
	</table>
	@else
	<h3>Aucun livre dans le comparateur</h3>
	@endif
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
	let base_url = "{{ $url }}";
</script>
<script src="{{ URL::asset('js/comparator_table.js') }}"></script>
@endsection