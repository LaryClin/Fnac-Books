@extends('layouts.search')

@section('search')

<h1>Recherche par editeur</h1>
@foreach ($editeurs as $editeur)
	<div>
		<h2><a href="{{ url('/search/editeur') }}/{{ $editeur->edi_id }}">{{ $editeur->edi_nom }}</a></h2>
	</div>
@endforeach

@endsection