@extends('layouts.search')

@section('search')

<h1>Recherche par format</h1>
@foreach ($formats as $format)
	<div>
		<h2><a href="{{ url('/search/format') }}/{{ $format->for_id }}">{{ $format->for_libelle }}</a></h2>
	</div>
@endforeach

@endsection