@extends('layouts.app')

@section('content')
<div class="container">
	@if(!$commandes[0]->adh_id)
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-danger" role="alert">
		        Il n'y a pas d'adhérent pour cette commande. Ce n'est pas normal. Contactez un administrateur.
		    </div>
		</div>
	</div>
	@endif

	@if(!$commandes[0]->adr_id && !$commandes[0]->mag_id && !$commandes[0]->rel_id)
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-danger" role="alert">
		        Il n'y a pas d'adresse pour cette commande. La livraison ne peut pas être effectué.
		    </div>
		</div>
	</div>
	@endif

	<div class="row">
		<div class="col-xs-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4 text-center">
							<h3>Commande n°{{ $commandes[0]->com_id }}</h3>
						</div>
						<div class="col-xs-4 text-center"><h3>Etat : 
							@if($commandes[0]->cli_id)
								{{ $commandes[0]->cli_datelivraison }}
							@else
								Préparation pour livraison
							@endif
							</h3>
						</div>
						<div class="col-xs-4 text-center">
							@if($commandes[0]->cli_id)
								<a style="margin-top: 16px;" class="btn btn-primary disabled">En cours de livraison ...</a>
							@elseif((!$commandes[0]->adr_id && !$commandes[0]->mag_id && !$commandes[0]->rel_id) || !$commandes[0]->adh_id)
								<a style="margin-top: 16px;" class="btn btn-danger disabled">Erreur</a>
							@else
								@if(Auth::user()->isCustomerService() or Auth::user()->isAdmin())
								<a style="margin-top: 16px;" href="./livrer/{{ $commandes[0]->com_id }}" class="btn btn-primary">Commencer la livraison</a>
								@else
								<a style="margin-top: 16px;"class="btn btn-primary">En préparation</a>
								@endif
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		@if($commandes[0]->adh_id)
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
								<input type="text" value="{{ $commandes[0]->adh_numadherent }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-6">
							<p>
								<label>Date fin adhésion</label>
								<input type="text" value="{{ $commandes[0]->adh_datefinadhesion }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<p>
								<label>E-mail</label>
								<input type="text" value="{{ $commandes[0]->adh_mel }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-6">
							<p>
								<label>Pseudonyme</label>
								<input type="text" value="{{ $commandes[0]->adh_pseudo }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2">
							<p>
								<label>Civilite</label>
								<input type="text" value="{{ $commandes[0]->adh_civilite }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-5">
							<p>
								<label>Nom</label>
								<input type="text" value="{{ $commandes[0]->adh_nom }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-5">
							<p>
								<label>Prénom</label>
								<input type="text" value="{{ $commandes[0]->adh_prenom }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<p>
								<label>Téléphone fixe</label>
								<input type="text" value="{{ $commandes[0]->adh_telfixe }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-6">
							<p>
								<label>Téléphone portable</label>
								<input type="text" value="{{ $commandes[0]->adh_telportable }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		@if($commandes[0]->adr_id)
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
								<input type="text" value="{{ $commandes[0]->adr_nom }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<p>
								<label>Rue</label>
								<input type="text" value="{{ $commandes[0]->adr_rue }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<p>
								<label>Complément rue</label>
								<input type="text" value="{{ $commandes[0]->adr_complementrue }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<p>
								<label>Code Postal</label>
								<input type="text" value="{{ $commandes[0]->adr_cp }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-5">
							<p>
								<label>Ville</label>
								<input type="text" value="{{ $commandes[0]->adr_ville }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-4">
							<p>
								<label>Pays</label>
								<input type="text" value="{{ $commandes[0]->pay_nom }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
	@if($commandes[0]->mag_id)
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">
				<div class="panel-heading">
					<h4>Magasin</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4">
							<p>
								<label>ID</label>
								<input type="text" value="{{ $commandes[0]->mag_id }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-4">
							<p>
								<label>Nom</label>
								<input type="text" value="{{ $commandes[0]->mag_nom }}" class="form-control" readonly/>
							</p>
						</div>
						<div class="col-xs-4">
							<p>
								<label>Ville</label>
								<input type="text" value="{{ $commandes[0]->mag_ville }}" class="form-control" readonly/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

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
							@foreach($commandes as $commande)
							<tr>
								<td>{{ $commande->liv_titre }}</td>
								<td title="{{ $commande->liv_histoire }}">{{ $commande->liv_histoire_short }}</td>
								<td>{{ $commande->liv_isbn }}</td>
								<td>{{ $commande->liv_stock }}</td>
								<td>{{ $commande->lec_quantite }}</td>
								<td>{{ $commande->liv_prixttc }}€</td>
								<td>{{ $commande->liv_prixttc * $commande->lec_quantite }}€</td>
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
								<th>{{ $total }}€</th>
							</tr>
						</tfoot>
					</table>
					{{ $commandes->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection