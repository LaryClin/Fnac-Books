@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<a class="btn btn-default" role="button" href="{{ url('/search/auteur') }}">Recherche par auteur</a>
		<a class="btn btn-default" role="button" href="{{ url('/search/genre') }}">Recherche par genre</a>
		<a class="btn btn-default" role="button" href="{{ url('/search/rubrique') }}">Recherche par rubrique</a>
		<a class="btn btn-default" role="button" href="{{ url('/search/editeur') }}">Recherche par éditeur</a>
		<a class="btn btn-default" role="button" href="{{ url('/search/format') }}">Recherche par format</a>
	</div>
</div>

@endsection