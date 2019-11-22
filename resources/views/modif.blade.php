@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel">
            <div class="panel-body">
            <div class="panel-heading">Informations de compte</div>
                <table class="table table-sm">
                    <tbody>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Nom</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{$user->adh_nom }}" data-champ="adh_nom" data-nom="nom">{{$user->adh_nom }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Prénom</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $user->adh_prenom }}" data-champ="adh_prenom" data-nom="prenom">{{ $user->adh_prenom }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Pseudo</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $user->adh_pseudo }}" data-champ="adh_pseudo" data-nom="pseudo">{{ $user->adh_pseudo }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Mot de passe</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="" data-champ="adh_motpasseold" data-nom="mot de passe">Entrez votre mot de passe actuel</td>
                            </tr>
                            
                            <tr class="mdp">
                                
                                <td class="col-xs-1"><label class="label-modif">Nouveau mot de passe</label></td>
                                <td class="col-xs modify mdp" data-id="{{ $user->adh_id }}" data-value="" data-champ="adh_motpasse" data-nom="mot de passe">Entrez votre nouveau mot de passe</td>
                            </tr>

                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Mail</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $user->adh_mel }}" data-champ="adh_mel"data-nom="mail">{{ $user->adh_mel }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Téléphone fixe</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $user->adh_telfixe }}" data-champ="adh_telfixe" data-nom="téléphone fixe">{{ $user->adh_telfixe }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Téléphone portable</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $user->adh_telportable }}" data-champ="adh_telportable" data-nom="téléhone portable">{{ $user->adh_telportable }}</td>
                            </tr>
                    </tbody>
                </table>
        </div>
                <div class="panel-footer">
                    <p>Pour modifier une information : <b>Double-cliquez</b> dessus.</p>
                </div>
    </div>

            <div class="panel">
            <div class="panel-body">
            <div class="panel-heading">Informations d'adresse</div>
                <table class="table table-sm">
                    <tbody>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Nom adresse</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{$adresses->adr_nom }}" data-champ="adr_nom" data-nom="nom d'adresse">{{$adresses->adr_nom }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Rue</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{$adresses->adr_rue }}" data-champ="adr_rue" data-nom="rue">{{$adresses->adr_rue }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Complément de rue</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $adresses->adr_complementrue }}" data-champ="adr_complementrue" data-nom="complément de rue">{{ $adresses->adr_complementrue }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Code postal</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $adresses->adr_cp }}" data-champ="adr_cp"data-nom="code postal">{{ $adresses->adr_cp }}</td>
                            </tr>
                            <tr>
                                <td class="col-xs-1"> <label class="label-modif">Ville</label></td>
                                <td class="col-xs modify" data-id="{{ $user->adh_id }}" data-value="{{ $adresses->adr_ville }}" data-champ="adr_ville" data-nom="ville">{{ $adresses->adr_ville }}</td>
                            </tr>
                    </tbody>
                </table>
        </div>
                <div class="panel-footer">
                    <p>Pour modifier une information : <b>Double-cliquez</b> dessus.</p>
                </div>
    </div>

</div>
</div>

<script src="{{ URL::asset('js/modif.js') }}"></script>
@endsection
