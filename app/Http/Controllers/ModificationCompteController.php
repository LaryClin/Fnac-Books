<?php

namespace App\Http\Controllers;
use App\User;
use App\Address;
use App\Pays;
use App\Magasin;
use App\Relais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ModificationCompteController extends Controller
{
    

    public function modif()
    {
        $user = Auth::user();
        $adresses = Address::where('adh_id', $user->adh_id)->first();

        /*$relais = Relais::all();
        $magasins = Magasin::all();*/
        $test = [];
        $viewParams = [
            'user' => $user,
            'adresses' => $adresses,
            //'relais' => $relais,
            //'magasins' => $magasins
        ];
        
        return view('modif', $viewParams);
    }

    public function modify(Request $request)
    {
        // Récupération des informations du POST
        $champ = $request->input("champ");
        $adh_id = $request->input("adh_id");
        $typeChamp = $request->input("typeChamp");
        $nomChampError = $request->input("nomChampError");

        //Récupération de la donnée en BDD
        $user = User::find($adh_id);
        $adresse = Address::where('adh_id', $adh_id)->first();

        //Declaration du tableau qui contient le nom des erreurs
        $errors = [];
        //Declaration a false de la verification du mot de passe
        $motpasse = false;

        //Vérification si les champs respectent les conditions
        if((strlen($champ) > 50 || gettype($champ) !== "string" || preg_match("/^[A-Z][\p{L}-]*$/", $champ) == false) && $typeChamp == "adh_nom")
            $errors[] = "adh_nom";

        if((strlen($champ) > 50 || gettype($champ) !== "string" || preg_match("/^[A-Z][\p{L}-]*$/", $champ) == false) && $typeChamp == "adh_prenom")
            $errors[] = "adh_prenom";

        if((strlen($champ) > 20 || gettype($champ) !== "string") && $typeChamp == "adh_pseudo")
            $errors[] = "adh_pseudo";

        if((strlen($champ) > 20 || gettype($champ) !== "string" || preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $champ)==false) && $typeChamp == "adh_mel")
            $errors[] = "adh_mel";

        if((strlen($champ) > 15 || gettype($champ) !== "string"  || preg_match("/^(04|09|01)[0-9]{8,9}$/", $champ)==false) && $typeChamp == "adh_telfixe")
            $errors[] = "adh_telfixe";

        if((strlen($champ) > 15 || gettype($champ) !== "string"  || preg_match("/^(06|07|041|039|034|044)[0-9]{8,9}$/", $champ)==false) && $typeChamp == "adh_telportable")
            $errors[] = "adh_telportable";

        if((strlen($champ) < 6 || gettype($champ) !== "string") && $typeChamp == "motpasse")
            $errors[] = "adh_motpasse";

        if((strlen($champ) > 50 || gettype($champ) !== "string") && $typeChamp == "adr_nom")
            $errors[] = "adr_nom";

        if((strlen($champ) > 255 || gettype($champ) !== "string") && $typeChamp == "adr_rue")
            $errors[] = "adr_rue";

        if((strlen($champ) > 200 || gettype($champ) !== "string") && $typeChamp == "adr_complementrue")
            $errors[] = "adr_complementrue";

        if((gettype($champ) !== "string"  || preg_match("/^[0-9]{5,5}$/", $champ)==false) && $typeChamp == "adr_cp")
            $errors[] = "adr_cp";

        if((strlen($champ) > 100 || gettype($champ) !== "string") && $typeChamp == "adr_ville")
            $errors[] = "adr_ville";


        //S'il n'y a pas d'erreur dans la saisie des champs
        if(($user || $adresse) && count($errors)==0)
        {
            if($typeChamp == "adh_nom")          
                $user->adh_nom = $champ;

            if($typeChamp == "adh_prenom")           
                $user->adh_prenom = $champ;

            if($typeChamp == "adh_pseudo")         
                $user->adh_pseudo = $champ;

            if($typeChamp == "adh_mel")         
                $user->adh_mel = $champ;

            if($typeChamp == "adh_telfixe")            
                $user->adh_telfixe = $champ;

            if($typeChamp == "adh_telportable")       
                $user->adh_telportable = $champ;

            if($typeChamp == "adr_nom")          
                $adresse->adr_nom = $champ;

            if($typeChamp == "adr_rue")           
                $adresse->adr_rue = $champ;

            if($typeChamp == "adr_complementrue")         
                $adresse->adr_complementrue = $champ;

            if($typeChamp == "adr_cp")         
                $adresse->adr_cp = $champ;

            if($typeChamp == "adr_ville")            
                $adresse->adr_ville = $champ;

            if($typeChamp == "adh_motpasseold" && password_verify($champ, $user->adh_motpasse))
                 $motpasse = true;

            if($typeChamp == "adh_motpasse")
                 $user->adh_motpasse = password_hash($champ, PASSWORD_BCRYPT);     
               

            $user->timestamps = false;
            $user->save();
            $adresse->timestamps = false;
            $adresse->save();
        }

        return response()->json(["error" => $errors, "nomChampError" => $nomChampError, "motpasse" => $motpasse]);
    
    
}
}