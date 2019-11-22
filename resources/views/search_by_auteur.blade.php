@extends('layouts.search')

@section('search')

<h1>Rechercher par auteur</h1>
<form class="form-group" method="get" action="{{ url('/search/auteur/results')}}">
	<div class="row">
		<div class="col-xs-4">    
			<label for="author_name">Nom de l'auteur</label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name') }}" required>
		</div>
		<div class="col-xs-4">
			<button type="submit" value="insert" class="mt-2 btn btn-primary">
				Rechercher
			</button>
		</div>
	</div>
</form>

@endsection

@section('custom_js')
<script src="{{ URL::asset('js/search_field.js') }}"></script>
@endsection