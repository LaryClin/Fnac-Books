@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        <form action="{{ url('/genre') }}" method="post" class="form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-xs-4">    
                    <label for="libelle">Libellé du genre à ajouter</label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" name="libelle" id="genre" class="form-control" value="{{ old('libelle') }}">
                </div>
                <div class="col-xs-4">
                    <button type="submit" value="insert" class="mt-2 btn btn-primary">
                        Ajouter
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-body">
                <table class="table table-sm">
                    <thead class="text-center">
                        <tr>
                            <td>Libelle Genre</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td class="col-xs-10 modify-genre" data-id="{{ $genre->gen_id }}" data-libelle="{{ $genre->gen_libelle }}">{{ $genre->gen_libelle }}</td>
                                <td><button data-id="{{ $genre->gen_id }}" data-libelle="{{ $genre->gen_libelle }}" class="btn btn-danger supprimer-genre-btn col-xs-12 {{ $genre->classTag }}">Supprimer</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $genres->links() }}
                </div>
            </div>
            <div class="panel-footer">
                <p>Pour modifier un genre : <b>Double-cliquez</b> dessus.</p>
                
            </div>
        </div>
    </div>
</div>

<div id="erreur-supprimer-genre" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Erreur !</h4>
      </div>
      <div class="modal-body">
        <p id="modal-error">Il semblerait que des livres ont encore le genre "<mark class="modal-libelle"></mark>" d'attribué.<br/>
        Assurez-vous que ce ne soit plus le cas pour supprimer ce genre.</p>
        <p id="modal-confirmation">
            Êtes-vous sûr de supprimer "<mark class="modal-libelle"></mark>" ?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button id="btn-modal-supression" type="button" class="btn btn-danger" data-dismiss="modal">Supprimer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="{{ URL::asset('js/genre.js') }}"></script>
@endsection
