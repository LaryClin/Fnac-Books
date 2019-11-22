@extends('layouts.app')

@section('content')
<div class="container">

	<form action="{{ url('/commande/validate') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
		<div class="row">
			<div class="col-xs-6">
				<div class="panel">
					<div class="panel-heading">
						<h4>Adhérent</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6">
								<p>
									<label>Numéro adhérent</label>
									<input type="text" value="{{ $user->adh_numadherent }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-6">
								<p>
									<label>Date fin adhésion</label>
									<input type="text" value="{{ $user->adh_datefinadhesion }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<p>
									<label>E-mail</label>
									<input type="text" value="{{ $user->adh_mel }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-6">
								<p>
									<label>Pseudonyme</label>
									<input type="text" value="{{ $user->adh_pseudo }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2">
								<p>
									<label>Civilite</label>
									<input type="text" value="{{ $user->adh_civilite }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-5">
								<p>
									<label>Nom</label>
									<input type="text" value="{{ $user->adh_nom }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-5">
								<p>
									<label>Prénom</label>
									<input type="text" value="{{ $user->adh_prenom }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<p>
									<label>Téléphone fixe</label>
									<input type="text" value="{{ $user->adh_telfixe }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-6">
								<p>
									<label>Téléphone portable</label>
									<input type="text" value="{{ $user->adh_telportable }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="panel">
					<div class="panel-heading">
						<h4>Adresse</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">
								<p>
									<label>Nom adresse</label>
									<input type="text" value="{{ $user->adresse->adr_nom }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<p>
									<label>Rue</label>
									<input type="text" value="{{ $user->adresse->adr_rue }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<p>
									<label>Complément rue</label>
									<input type="text" value="{{ $user->adresse->adr_complementrue }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<p>
									<label>Code Postal</label>
									<input type="text" value="{{ $user->adresse->adr_cp }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-5">
								<p>
									<label>Ville</label>
									<input type="text" value="{{ $user->adresse->adr_ville }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-4">
								<p>
									<label>Pays</label>
									<input type="text" value="{{ $user->adresse->pays->pay_nom }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			@if($user->mag_id)
			<div class="col-xs-6">
				<div class="panel">
					<div class="panel-heading">
						<h4>Relais</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6">
								<p>
									<label>Nom</label>
									<input type="text" value="{{ $user->magasin->mag_nom }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-6">
								<p>
									<label>Ville</label>
									<input type="text" value="{{ $user->magasin->mag_ville }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
			@if($user->relaisAdherent)
			<div class="col-xs-6">
				<div class="panel">
					<div class="panel-heading">
						<h4>Point relais</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">
								<p>
									<label>Nom adresse</label>
									<input type="text" value="{{ $user->relaisAdherent->relais->rel_nom }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<p>
									<label>Rue</label>
									<input type="text" value="{{ $user->relaisAdherent->relais->rel_rue }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<p>
									<label>Code Postal</label>
									<input type="text" value="{{ $user->relaisAdherent->relais->rel_cp }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-5">
								<p>
									<label>Ville</label>
									<input type="text" value="{{ $user->relaisAdherent->relais->rel_ville }}" class="form-control" readonly/>
								</p>
							</div>
							<div class="col-xs-4">
								<p>
									<label>Pays</label>
									<input type="text" value="{{ $user->relaisAdherent->relais->pays->pay_nom }}" class="form-control" readonly/>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="col-xs-12">
				<div class="panel">
					<div class="panel-heading">
						<h4>Choix de la livraison</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">

								@if(Auth::user()->adresse)
								<label class="radio-inline">
									<input type="radio" name="option-livraison" value="domicile" required>A domicile
								</label>
								@endif
								@if(Auth::user()->mag_id)
								<label class="radio-inline">
									<input type="radio" name="option-livraison" value="magasin" required>En magasin
								</label>
								@endif
								@if(Auth::user()->relaisAdherent)
								<label class="radio-inline">
									<input type="radio" name="option-livraison" value="relais" required>En point relais
								</label>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel">
					<div class="panel-heading">
						<h4>Objets de la commande</h4>
					</div>
					<div class="panel-body">
						<table class="table">
							<thead>
								<tr>
									<th class="col-xs">Livre</th>
									<th class="col-xs-3">Description</th>
									<th class="col-xs-1">ISBN</th>
									<th class="col-xs-1">Stock</th>
									<th class="col-xs-1">Quantite</th>
									<th class="col-xs-1">Prix TTC</th>
									<th class="col-xs-1">Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach($livres as $livre)
								<tr>
									<td>{{ $livre->liv_titre }}</td>
									<td title="{{ $livre->liv_histoire }}">{{ $livre->liv_histoire }}</td>
									<td>{{ $livre->liv_isbn }}</td>
									<td>{{ $livre->liv_stock }}</td>
									<td>{{ $livre->attributes['qte'] }}</td>
									<td>{{ $livre->liv_prixttc }}€</td>
									<td>{{ $livre->liv_prixttc * $livre->attributes['qte'] }}€</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Total :</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>{{ $totalprice }}€</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12" align="right">

				<button type="submit" class="btn btn-primary" name="validecommande_btn">Valider</button>

			</div>
		</div>

	</form>

</div>
@endsection

@section('custom_js')
<script src="{{ URL::asset('js/validate_commande.js') }}"></script>
@endsection