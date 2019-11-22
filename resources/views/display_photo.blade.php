@extends('layouts.app')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/image.css') }}">
@endsection

@section('content')
<div class="container">
	<div class="panel">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
					<h2>{{ $livre->liv_titre }}</h2>
				</div>
				<div class="col">
					<form class="form-inline" action="{{ url('/photos') }}/add/{{ $livre->liv_id }}" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for="new_photo">Votre photo</label>
							<input type="file" id="new_photo" name="new_photo">
							<p class="help-block">Super text</p>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" name="send_photo" id="send_photo">
						</div>
						<input type="hidden"  name="_token" value="{{ csrf_token() }}" >
					</form>
				</div>
				<div class="col-xs-12">
					<div class="row">
						@foreach($photos as $photo)
						<div class="col-xs-3 img_col" data-id="{{ $photo->pho_id }}">
							<img src="{{ url('/') }}{{$photo->pho_url}}" class="img-responsive img-thumbnail img_delete" style="width: 300px" data-id="{{ $photo->pho_id }}" />
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal-delete-img" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Confirmation de suppression</h4>
			</div>
			<div class="modal-body">
				<p id="modal-warning">Vous êtes sur le point de supprimer cette photo</p>
				<img data-id="-1" id="modal-img" style="width: 100%" /> <!-- setup in js --> 
				<p id="modal-confirmation">
					Êtes-vous sûr de vouloir la supprimer ?
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				<button id="btn-delete-img" type="button" class="btn btn-danger" data-dismiss="modal">Supprimer</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
<script type="text/javascript">
	let base_url = "{{ url('/') }}";
</script>
<script src="{{ URL::asset('js/images.js') }}"></script>
@section('custom_js')

@endsection
