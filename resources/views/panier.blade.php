@extends('layouts.app')

@section('content')

<div class="container">
	@if($id_livres != null)
		@foreach($livres as $livre)
			<?php $i=-1;?>
			
			@foreach($id_livres as $id)
				<?php $i++; ?>
				
				@if($id == $livre['liv_id'])
				<div data-id="{{ $livre->liv_id }}">
					@foreach($photos as $photo)
						@if($id == $photo['liv_id'])
							<img style="width:100px;" class="img-thumbnail"  src="{{$photo->pho_url}}" data-id="{{ $livre->liv_id }}">
						@endif
					@endforeach
					<h3 data-id="{{ $livre->liv_id }}" class="text-xl-left">{{$livre->liv_titre}}</h3>
					<p data-id="{{ $livre->liv_id }}" class="text-xl-left">Date parution : {{$livre->liv_dateparution}}</p>
					<p data-id="{{ $livre->liv_id }}">{{$livre->liv_prixttc}}€</p>
					<label data-id="{{ $livre->liv_id }}">Nombre d'articles dans le panier : </label>
					<input data-id="{{ $livre->liv_id }}" type="number" class="form-control" value="{{$quantite[$i]}}"/>
					<button class="btn btn-danger del_livre"  value="{{$id}}" data-stock="{{$livre->liv_stock}}" data-id="{{$livre->liv_id}}">Supprimer du panier</button>
				</div>
				@endif

			@endforeach
		@endforeach
	@else
		<h3 class="text-center">Vous n'avez rien dans votre panier</h3>
		<a class=" btn btn-danger" href="{{ url('/search') }}"><h3 >Rechercher</h3></a>
	@endif
</div>
<script src="{{ URL::asset('js/remove_basket.js') }}"></script>
@endsection