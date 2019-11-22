@extends('layouts.app')

@section('content')

	<div class="container">
	    <div>
		
	    	@yield('search')

	    </div>
	    @section('button')
	    <div>
	    	<a class="btn btn-default" href="{{ url('/search') }}" role="button">Retour au menu de recherche</a>
	    	@yield('back_button')
	    </div>
	    @endsection
	</div>  

@endsection