@extends('layouts.app')

@section('content')

<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th scope="col" class="col-xs-2">Numéro</th>
				<th scope="col" class="col-xs-2">Pseudo</th>
				<th scope="col" class="col-xs-2">Nom</th>
				<th scope="col" class="col-xs-2">Prénom</th>
				<th scope="col" class="col-xs-2">Role</th>
				<th scope="col" class="col-xs-2">Validation</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
			<tr data-adh_id="{{ $user->adh_id }}">
				<td class="col-xs-2">{{ $user->adh_numadherent }}</td>
				<td class="col-xs-2">{{ $user->adh_pseudo }}</td>
				<td class="col-xs-2">{{ $user->adh_nom }}</td>
				<td class="col-xs-2">{{ $user->adh_prenom }}</td>
				<td class="col-xs-2">
					@if (Auth::user()->adh_id == $user->adh_id)
					{{ $user->roleadherent->attributes['role']->rol_libelle }}
					@else
					<select class="role_select form-control" data-adh_id="{{ $user->adh_id }}">
						@foreach ($roles as $role)
						@if ($user->roleadherent->attributes['rol_id'] == $role->rol_id)
						<option value="{{ $role->rol_id }}" selected="selected">{{ $role->rol_libelle }}</option>
						@else
						<option value="{{ $role->rol_id }}">{{ $role->rol_libelle }}</option>
						@endif
						@endforeach
					</select>
					@endif
				</td>
				<td class="col-xs-2">
					@if (Auth::user()->adh_id != $user->adh_id)
					<button type="button" class="btn btn-default save_role_btn" data-adh_id="{{ $user->adh_id }}">Enregistrer</button>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $users->links() }}	
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
	let base_url = "{{ url('/') }}";
</script>
<script src="{{ URL::asset('js/role.js') }}"></script>
@endsection