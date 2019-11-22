@extends('layouts.search')

@section('search')

@if (count($avis) >= 1)
<h1>Résultats :</h1>
<select name="sort_by_date" data-col_name="avi_date" id="sort_by_date" class="sorting">
	<option value=""></option>
	<option value="desc">Récent</option>
	<option value="asc">Ancien</option>
</select>
<select name="sort_by_note" data-col_name="avi_note" id="sort_by_note" class="sorting">
	<option value=""></option>
	<option value="desc">Positif</option>
	<option value="asc">Négatif</option>
</select>
<div id="books">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Titre</th>
				<th scope="col" class="sorting" data->Note</th>
				<th scope="col">Description</th>
				<th scope="col" class="sorting">Date</th>
				<th scope="col">Adhérent</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($avis as $avi)
			<tr>
				<td>{{ $avi->avi_titre }}</a></td>
				<td>{{ $avi->avi_note }}</td>
				<td>{{ $avi->avi_detail }}</td>
				<td>{{ $avi->avi_date }}</td>
				<td>{{ $avi->adh_pseudo }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $avis->links() }}
@else
<h3>Aucun résultat.</h3>
@endif

@endsection

@section('button')
<div>
	<a class="btn btn-default" href="{{ $previous }}" role="button">Retour</a>
</div>
@endsection

@section('custom_js')
<script src="{{ URL::asset('js/get_avis.js') }}"></script>
@endsection