@extends('layouts.app')

@section('content')
@if (session('status'))
{{ session('status') }}
@endif
<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=Au0-HONhkfs1R1LCMRzxV3L35diP8Xhn2_BW0oFuUaAXiuF83iym7BmwH3Ac-91t' ></script>
<script type='text/javascript'>
    var map, infobox;

    function loadMapScenario() {
        map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(45.921341, 6.153685),
            zoom: 13
        });

        infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
            visible: false
        });

        
        infobox.setMap(map);

        //Creer les points relais
        @foreach($relais as $relai)
        var location = new Microsoft.Maps.Location("{{ $relai ->rel_latitude }}","{{ $relai ->rel_longitude }}" )
        var pin = new Microsoft.Maps.Pushpin(location);
        pin.metadata = {
            rel_id: '{{ $relai->rel_id}}',
            title: '{{ $relai->rel_nom}}',
            description: '{{ $relai->rel_rue}} <br> {{$relai->rel_cp}} {{$relai->rel_ville}}'
        }    



        Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);
        map.entities.push(pin);

        @endforeach
    }

    function pushpinClicked(e) {
        //Make sure the infobox has metadata to display.
        if (e.target.metadata) {
            //Set the infobox options with the metadata of the pushpin.
            infobox.setOptions({
                location: e.target.getLocation(),
                title: e.target.metadata.title,
                description: e.target.metadata.description,
                visible: true
            });
        }
        let inputPushpin = document.querySelector('#rel_id')
        inputPushpin.value = e.target.metadata.rel_id
        console.log(e.target.metadata.rel_id)
    }
</script>

</script>
<body onload="loadMapScenario();">
    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Register</div>
                        <div class="panel-body">

                                <input type="hidden" name="rel_id" id="rel_id"/>

                                <div class="form-group{{ $errors->has('adh_civilite') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Civilité</label> <br>
                                    <div class="col-md-6">

                                        <label for="Mr" class="">Mr.</label>

                                        <input id="Mr" type="radio" class="form-control" name="adh_civilite" value="M." required autofocus/>



                                        <label for="Mme" class="">Mme</label>

                                        <input id="Mme" type="radio" class="form-control" name="adh_civilite" value="Mme" required autofocus/>

                                        <label for="Mlle" class="">Mlle</label>

                                        <input id="Mlle" type="radio" class="form-control" name="adh_civilite" value="Mlle" required autofocus/>


                                        @if ($errors->has('adh_civilite'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_civilite') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_nom') ? ' has-error' : '' }}">
                                    <label for="adh_nom" class="col-md-4 control-label">Nom</label>

                                    <div class="col-md-6">
                                        <input id="adh_nom" type="text" class="form-control" name="adh_nom" value="{{ old('adh_nom') }}" required autofocus>

                                        @if ($errors->has('adh_nom'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_nom') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_prenom') ? ' has-error' : '' }}">
                                    <label for="adh_prenom" class="col-md-4 control-label">Prénom</label>

                                    <div class="col-md-6">
                                        <input id="adh_prenom" type="text" class="form-control" name="adh_prenom" value="{{ old('adh_prenom') }}" required autofocus>

                                        @if ($errors->has('adh_prenom'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_prenom') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_pseudo') ? ' has-error' : '' }}">
                                    <label for="adh_pseudo" class="col-md-4 control-label">Pseudo</label>

                                    <div class="col-md-6">
                                        <input id="adh_pseudo" type="text" class="form-control" name="adh_pseudo" value="{{ old('adh_pseudo') }}" required autofocus>

                                        @if ($errors->has('adh_pseudo'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_pseudo') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('adh_mel') ? ' has-error' : '' }}">
                                    <label for="adh_mel" class="col-md-4 control-label">Adresse E-mail</label>

                                    <div class="col-md-6">
                                        <input id="adh_mel" type="email" class="form-control" name="adh_mel" value="{{ old('adh_mel') }}" required>

                                        @if ($errors->has('adh_mel'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_mel') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_motpasse') ? ' has-error' : '' }}">
                                    <label for="adh_motpasse" class="col-md-4 control-label">Mot de passe</label>

                                    <div class="col-md-6">
                                        <input id="adh_motpasse" type="password" class="form-control" name="adh_motpasse" required>

                                        @if ($errors->has('adh_motpasse'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_motpasse') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="adh_motpasse_confirmation" class="col-md-4 control-label">Confirmation Mot de passe</label>

                                    <div class="col-md-6">
                                        <input id="adh_motpasse_confirmation" type="password" class="form-control" name="adh_motpasse_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_telfixe') ? ' has-error' : '' }}">
                                    <label for="telfixe" class="col-md-4 control-label">Téléphone fixe</label>

                                    <div class="col-md-6">
                                        <input id="adh_telfixe" type="text" class="form-control" name="adh_telfixe">

                                        @if ($errors->has('adh_telfixe'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_telfixe') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('adh_telportable') ? ' has-error' : '' }}">
                                    <label for="adh_telportable" class="col-md-4 control-label">Téléphone portable</label>

                                    <div class="col-md-6">
                                        <input id="adh_telportable" type="text" class="form-control" name="adh_telportable">

                                        @if ($errors->has('telportable'))
                                        <span class="help-block"> <strong>{{ $errors->first('adh_telportable') }}</strong> </span>
                                        @endif
                                    </div>
                                </div>


                            <!--<div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>


                        </form>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Adresse de livraison et facturation</div>
                    <div class="panel-body">

                        <div class="form-group{{ $errors->has('mag_id') ? ' has-error' : '' }}">
                            <label for="mag_id" class="col-md-4 control-label">Magasin préféré</label>

                            <div class="col-md-6">
                                <select name="mag_id" id="mag_id" class="form-control">
                                @foreach($magasins as $magasin)
                                    <option value="{{ $magasin->mag_id }}">{{ $magasin->mag_nom }}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('mag_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mag_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('adr_nom') ? ' has-error' : '' }}">
                            <label for="adh_pseudo" class="col-md-4 control-label">Nom de l'adresse</label>

                            <div class="col-md-6">
                                <input id="adr_nom" type="text" class="form-control" name="adr_nom" value="{{ old('adr_nom') }}" required autofocus>

                                @if ($errors->has('adr_nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adr_nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adr_rue') ? ' has-error' : '' }}">
                            <label for="adr_rue" class="col-md-4 control-label">Rue</label>

                            <div class="col-md-6">
                                <input id="adr_rue" type="text" class="form-control" name="adr_rue" value="{{ old('adr_rue') }}" required autofocus>

                                @if ($errors->has('adr_rue'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adr_rue') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adr_complementrue') ? ' has-error' : '' }}">
                            <label for="adr_complementrue" class="col-md-4 control-label">Complément de rue</label>

                            <div class="col-md-6">
                                <input id="adr_complementrue" type="text" class="form-control" name="adr_complementrue" value="{{ old('adr_complementrue') }}" required autofocus>

                                @if ($errors->has('adr_complementrue'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adr_complementrue') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adr_cp') ? ' has-error' : '' }}">
                            <label for="adr_cp" class="col-md-4 control-label">Code postal</label>

                            <div class="col-md-6">
                                <input id="adr_cp" type="text" class="form-control" name="adr_cp" value="{{ old('adr_cp') }}" required autofocus>

                                @if ($errors->has('adr_cp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adr_cp') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adr_ville') ? ' has-error' : '' }}">
                            <label for="adr_ville" class="col-md-4 control-label">Ville</label>

                            <div class="col-md-6">
                                <input id="adr_ville" type="text" class="form-control" name="adr_ville" value="{{ old('adr_ville') }}" required autofocus>

                                @if ($errors->has('adr_ville'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adr_ville') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pay_nom') ? ' has-error' : '' }}">
                            <label for="pay_id" class="col-md-4 control-label">Pays</label>

                            <div class="col-md-6">
                                <select name="pay_id" id="pay_id" class="form-control">

                                @foreach($pays as $pay)
                                <option value="{{ $pay->pay_id }}"> {{ $pay->pay_nom }}</option>
                                @endforeach
                        </select>

                        @if ($errors->has('pay_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pay_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('adr_type') ? ' has-error' : '' }}">
                    <label for="adr_type" class="col-md-4 control-label">Type d'adresse</label>

                    <div class="col-md-6">
                        <input type="checkbox" name="adr_type" value="Facturation">Facturation
                        <input type="checkbox" name="adr_type" value="Livraison">Livraison

                        @if ($errors->has('adr_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('adr_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
</form>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Les points relais à proximité</div>
                <div class="panel-body">
                    <div id="myMap" style='position:relative;width:600px;height:400px;'></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

@endsection
