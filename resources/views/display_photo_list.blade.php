@extends('layouts.app')

@section('content')
<div class="container">
	@if (count($books) >= 1)
	<h1>Les livres :</h1>
	<div id="books">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Titre</th>
					<th scope="col">Auteur(s)</th>
					<th scope="col">Editeur</th>
					<th scope="col">Format</th>
					<th scope="col">Prix</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($books as $book)
				<tr>
					<td><a href="{{ url('/photos') }}/{{ $book->liv_id }}">{{ $book->liv_titre }}</a></td>
					<td>{{ $book->auteurs->pluck('aut_nom')->implode(", ") }}</td>
					<td>{{ $book->edi_nom }}</td>
					<td>{{ $book->for_libelle }}</td>
					<td>{{ $book->liv_prixttc }}€</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	{{ $books->links() }}
	@else
	<h3>Aucun livre n'a été trouvé</h3>
	@endif
</div>
@endsection