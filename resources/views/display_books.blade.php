@extends('layouts.search')

@section('search')

@if (count($books) >= 1)
<h1>Résultats :</h1>
<div id="books">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Titre</th>
				<th scope="col">Auteur(s)</th>
				<th scope="col">Editeur</th>
				<th scope="col">Format</th>
				<th scope="col">Prix</th>
				<th scope="col">Comparateur</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($books as $book)
			<tr>
				<td><a href="{{ url('/consulter') }}/{{ $book->liv_id }}">{{ $book->liv_titre }}</a></td>
				<td>{{ $book->auteurs->pluck('aut_nom')->implode(", ") }}</td>
				<td>{{ $book->edi_nom }}</td>
				<td>{{ $book->for_libelle }}</td>
				<td>{{ $book->liv_prixttc }}€</td>
				<td>
					@if($book->isCompare)
					<button class="btn btn-danger comparator_button" data-comparator="in" data-id="{{$book->liv_id}}">Supprimer du comparateur</button>
					@else
					<button class="btn btn-success comparator_button" data-comparator="not_in" data-id="{{$book->liv_id}}">Ajouter au comparateur</button>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div id="erreur-comparateur-complet" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Erreur !</h4>
			</div>
			<div class="modal-body">
				<p id="modal-error">Votre comparateur est complet !</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{ $books->links() }}
@else
<h3>Aucun résultat.</h3>
@endif

@endsection

@section('back_button')
<a class="btn btn-default" href="{{ $previous }}" role="button">Retour</a>
@endsection

@section('custom_js')
<script type="text/javascript">
	let base_url = "{{ $url }}";
</script>
<script src="{{ URL::asset('js/comparator.js') }}"></script>
@endsection