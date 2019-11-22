@extends('layouts.app')

@section('content')
<div class="container">
	@if(session('succes'))
	<div class="alert alert-success" role="alert">
		{{ session('succes') }}
	</div>
	@endif
	<div class="row">
		<div class="col">
			<div class="panel">
				<div class="panel-body">
					@if(count($all))
						<table class="table">
							<thead>
								<tr>
									<th>ID Avis</th>
									<th>Titre</th>
									<th>Détail</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($all as $avis)
								<tr>
									<td>{{ $avis->avi_id }}</td>
									<td>{{ $avis->avi_titre }}</td>
									<td>{{ $avis->avi_detail }}</td>
									<td>{{ $avis->avi_date }}</td>
									<td>
										
										<a href="/avis/deleteSignalement?avi_id={{ $avis->avi_id }}&adh_id={{ $avis->adh_id }}" class="btn btn-default">Supprimer le signalement</a>
										<a href="/avis/delete/{{ $avis->avi_id }}" class="btn btn-danger">Supprimer l'avis</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>	
					@else
					<p class="text-center">Il n'y a pas d'avis signalé.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection