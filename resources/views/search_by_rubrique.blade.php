@extends('layouts.search')

@section('search')

<h1>Recherche par rubrique</h1>
@foreach ($rubriques as $rubrique)
	<div>
		<h2><a href="{{ url('/search/rubrique') }}/{{ $rubrique->rub_id }}">{{ $rubrique->rub_libelle }}</a></h2>
	</div>
@endforeach

@endsection