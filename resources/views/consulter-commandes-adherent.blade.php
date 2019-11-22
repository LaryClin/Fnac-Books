@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>ID Commande</th>
								<th>Civilite</th>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Mail</th>
								<th>Tél. Fixe</th>
								<th>Tél. Portable</th>
								<th>Ville</th>
								<th>Pays</th>
								<th>Consulter</th>
							</tr>
						</thead>
						<tbody>
							@foreach($commandes as $commande)
							<tr>
								<td>{{ $commande->com_id }}</td>
								<td>{{ $commande->adherent->adh_civilite }}</td>
								<td>{{ $commande->adherent->adh_nom }}</td>
								<td>{{ $commande->adherent->adh_prenom }}</td>
								<td>{{ $commande->adherent->adh_mel }}</td>
								<td>{{ $commande->adherent->adh_telfixe }}</td>
								<td>{{ $commande->adherent->adh_telportable }}</td>
								<td>{{ $commande->adherent->adresse->adr_ville }}</td>
								<td>{{ $commande->adherent->adresse->pays->pay_nom }}</td> 
								<td><a href="{{ url('/') }}/commande/{{ $commande->com_id }}" class="btn btn-default">Consulter Détails</a></td> 
							</tr>
							@endforeach
						</tbody>
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection