@extends('layouts.app')

@section('content')
<div class="container">
	@if(count($livres) > 0)
	<h1>Mes favoris :</h1>
	<div id="books">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Titre</th>
					<th scope="col">Auteur(s)</th>
					<th scope="col">Editeur</th>
					<th scope="col">Format</th>
					<th scope="col">Prix</th>
					<th scope="col">Suppression</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($livres as $book)
				<tr data-id="{{$book->liv_id}}">
					<td><a href="{{ url('/consulter') }}/{{ $book->liv_id }}">{{ $book->liv_titre }}</a></td>
					<td>{{ $book->auteurs->pluck('aut_nom')->implode(", ") }}</td>
					<td>{{ $book->edi_nom }}</td>
					<td>{{ $book->for_libelle }}</td>
					<td>{{ $book->liv_prixttc }}€</td>
					<td>
						<button class="btn btn-danger fav_delete_button" data-comparator="in" data-id="{{$book->liv_id}}">Supprimer des favoris</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@else
		<h2>Aucun article en favoris</h2>
	@endif
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
	let base_url = "{{ $url }}"
</script>
<script src="{{ URL::asset('js/favoris.js') }}"></script>
@endsection