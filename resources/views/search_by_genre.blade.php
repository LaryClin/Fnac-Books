@extends('layouts.search')

@section('search')

<h1>Recherche par genre</h1>
@foreach ($genres as $genre)
	<div>
		<h2><a href="{{ url('/search/genre') }}/{{ $genre->gen_id }}">{{ $genre->gen_libelle }}</a></h2>
	</div>
@endforeach

@endsection