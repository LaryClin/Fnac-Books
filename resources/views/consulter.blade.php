@extends('layouts.app')

@section('content')
<div class="container">
	@if(session('succes'))
	<div class="alert alert-success" role="alert">
		{{ session('succes') }}
	</div>
	@endif

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-body">
				<div>
					<h2>{{$livre->liv_titre}}</h2>
					<h3>Prix : {{$livre->liv_prixttc}}€</h3>
					<p>{{$livre->liv_histoire}}</p>
					<div class="row">
						@foreach($photos as $photo)
						<div class="col-xs-4">
							<img src="{{ $url }}{{$photo->pho_url}}" class="img-responsive img-thumbnail" style="width: 300px">
						</div>
						@endforeach
					</div>
					<p>Date de parution : {{$livre->liv_dateparution}}</p>
					<p>ISBN : {{$livre->liv_isbn}}</p><br>
					<p>Stock : {{$livre->liv_stock}}</p>
				</div>
				@if (Auth::check())
				@if ($fav)
				<button class="btn btn-danger favorite_button" data-favorite="in" data-id="{{$livre->liv_id}}">Supprimer des favoris</button>
				@else
				<button class="btn btn-success favorite_button" data-favorite="not_in" data-id="{{$livre->liv_id}}">Ajouter aux favoris</button>
				@endif
				@endif
				@if($inComparator)
				<button class="btn btn-danger comparator_button" data-comparator="in" data-id="{{$livre->liv_id}}">Supprimer du comparateur</button>
				@else
				<button class="btn btn-success comparator_button" data-comparator="not_in" data-id="{{$livre->liv_id}}">Ajouter au comparateur</button>
				@endif
				<div class="add_basket">
					<button class="btn add_panier_button btn-warning" data-stock="{{$livre->liv_stock}}" data-id="{{$livre->liv_id}}">Ajouter au panier</button>
				</div>
				<div>
					<!--<h4><a href="/avis/all/{{ $id }}">Consulter Avis</a></h4>-->

					@if (count($avis) >= 1)
					<h1>Les avis :</h1>
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
									<th class="col-xs-1" scope="col">Titre</th>
									<th class="col-xs-1" scope="col" class="sorting" data->Note</th>
									<th class="col-xs-4" scope="col">Description</th>
									<th class="col-xs-1" scope="col" class="sorting">Date</th>
									<th class="col-xs-1" scope="col">Adhérent</th>
									@if (Auth::check())
									<th class="col-xs-3" scope="col">utile/pas utile</th>
									<th class="col-xs-1" scope="col">Action</th>
									@endif
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
									@if (Auth::check())
									<td>
										<div class="btn-group">
											@if(!$avi->myAvisUtileExist)
											<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=1" class="btn btn-default">oui({{ $avi->avi_nbutileoui }})</a>
											<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=0" class="btn btn-default">non({{ $avi->avi_nbutilenon }})</a>
											@else
												@if($avi->myAvisUtile)
													@if($avi->myAvisUtile->avu_utile)
													<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=1" class="btn btn-success">oui({{ $avi->avi_nbutileoui }})</a>
													<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=0" class="btn btn-default">non({{ $avi->avi_nbutilenon }})</a>
													@else
													<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=1" class="btn btn-default">oui({{ $avi->avi_nbutileoui }})</a>
													<a href="/avis/utile/add?avi_id={{ $avi->avi_id }}&adh_id={{ Auth::id() }}&utile=0" class="btn btn-danger">non({{ $avi->avi_nbutilenon }})</a>
													@endif
												@endif
											@endif
										</div>
									</td>
									@endif
									@if (Auth::check())
									<td>
										<a href="@if(!$avi->alreadySignaled)/avis/signaler/{{ $avi->avi_id }}@endif" class="btn btn-default @if($avi->alreadySignaled) disabled @endif">Signaler</a>
									</td>
									@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					{{ $avis->links() }}
					@else
					<h3>Aucun avis sur ce produit.</h3>
					@endif

					
			</div>
			@if (Auth::check() && $alreadyBought)
			<div class="panel-footer">
				@if(!$authedAvisExist)
				<h3>Ajouter votre avis</h3>
				<form class="form-group" action="/avis/add" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="adh_id" value="{{ Auth::id() }}">
					<input type="hidden" name="liv_id" value="{{ $livre->liv_id }}">
					<p>
						<label for="titre">Titre :</label>
						@if(session('errors') && in_array('avi_titre', session('errors')))
						<br/><span class="text-danger">Le titre ne doit pas dépasser 100 caractères.</span>
						@endif
						<input class="form-control" type="text" name="avi_titre" id="titre" maxlength="1000" placeholder="Titre (moins de 100 caractères)" oninput="document.querySelector('#titre-length').innerHTML = this.value.length;">
						<p class="col-xs-offset-11"><span id="titre-length">0</span> / 100</p>
					</p>
					<p>
						<label for="detail">Commentaire :</label>
						@if(session('errors') && in_array('avi_detail', session('errors')))
						<br/><span class="text-danger">Le commentaire ne doit pas dépasser 2000 caractères.</span>
						@endif
						<textarea class="form-control" name="avi_detail" id="detail" maxlength="2000" placeholder="Partagez à tous le monde ce que vous en pensez ! (Moins de 2000 caractères)" oninput="document.querySelector('#detail-length').innerHTML = this.value.length;" rows="10"></textarea>
						<p class="col-xs-offset-10 text-right"><span id="detail-length">0</span> / 2000</p>
					</p>
					<p>
						<label>Note : <span id="range-span">3</span> / 5</label>
						@if(session('errors') && in_array('avi_note', session('errors')))
						<br/><span class="text-danger">La note n'est pas comprise entre 1 et 5.</span>
						@endif
						<input class="form-control" type="range" name="avi_note" min="1" max="5" oninput="document.querySelector('#range-span').innerHTML = this.value;" value="3">
					</p>
					<input class="btn btn-primary" type="submit" name="">
				</form>
				@else
				<div class="row">
					<div class="col-xs-12">
						<h3>Votre avis :</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<p>
							<label for="titre">Titre :</label>
							<input type="text" class="form-control" value="{{ $myAvis->avi_titre }}" readonly>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<p>
							<label for="titre">Détail :</label>
							<input type="text" class="form-control" value="{{ $myAvis->avi_detail }}" readonly>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<p>
							<label for="titre">Note :</label>
							<input type="text" class="form-control" value="{{ $myAvis->avi_note }} / 5" readonly>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a href="/avis/delete/{{ $myAvis->avi_id }}" class="btn btn-default">Supprimer mon avis</a>
					</div>
				</div>
				@endif
			</div>
			@endif
		</div>
	</div>
</div>
<div id="erreur-comparateur-complet" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Erreur !</h4>
			</div>
			<div class="modal-body">
				<p id="modal-error">Votre comparateur est complet !</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('custom_js')

<script type="text/javascript">
	let base_url = "{{ url('/') }}";
	let livid = "{{ $livre->liv_id }}"

	@if (Auth::check())
	authed = true
	auth_id = "{{ Auth::id() }}";
	@else
	authed = false
	@endif
</script>

<script src="{{ URL::asset('js/get_avis.js') }}"></script>
<script src="{{ URL::asset('js/comparator.js') }}"></script>
<script src="{{ URL::asset('js/add_basket.js') }}"></script>
<script src="{{ URL::asset('js/favoris.js') }}"></script>
@endsection
