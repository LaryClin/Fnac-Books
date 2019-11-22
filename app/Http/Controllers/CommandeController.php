<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Commande;
use App\Livraison;
use App\Panier;
use App\LigneCommande;
use App\Livre;

class CommandeController extends Controller
{
	public $HISTOIRE_SHORT_LENGTH = 35;

    public function consulterAll()
    {
    	//$commandes = Commande::WithAdherent();
        $commandes = Commande::orderBy("com_date","DESC")->paginate(10);
    	//dump($commandes);
        //dump($commandes[2]->adherent);
        //dump(Commande::find(28)->adherent);
    	return view('consulter-commandes', ['commandes' => $commandes]);
    }
    public function consulterAdhID()
    {
        $id = Auth::user()->adh_id;
        //$commandes = Commande::idAdhJoined($id);
        $commandes = Commande::where("adh_id", $id)->orderBy("com_date","DESC")->paginate(10);
        //dump($commandes);
        return view('consulter-commandes-adherent', ['commandes' => $commandes]);
    }

    public function consulterID($id)
    {
        if (Auth::user()->adh_id != Commande::find($id)->adh_id && 
            (Auth::user()->roleadherent == null || 
            Auth::user()->roleadherent->attributes['rol_id'] != 1)) 
        {
            return redirect()->route('permissionError');
        }

    	$commandes = Commande::IdJoined($id);
        $adh_id = Commande::find($id)->adherent->adh_id;
        $commandes[0]->adh_id = $adh_id;
    	//dump($commandes);

    	$total = 0;

    	foreach ($commandes as $key => $commande) {
			$total += $commande->liv_prixttc * $commande->lec_quantite;

    		if(strlen($commande->liv_histoire) > $this->HISTOIRE_SHORT_LENGTH)
    		{
    			$commandes[$key]->liv_histoire_short = substr($commande->liv_histoire, 0, $this->HISTOIRE_SHORT_LENGTH-3) . "...";
    		}
    		else
    		{
    			$commandes[$key]->liv_histoire_short = $commande->liv_histoire;
    		}
    	}
    	return view('consulter-commande', ['commandes' => $commandes, 'total' => $total]);
    }

    public function passerEnLivre($id)
    {
    	$livraison = new Livraison();
    	$livraison->com_id = $id;
    	$livraison->cli_datelivraison = date('Y/m/d');
    	$livraison->save();

    	return redirect('/commande/' . $id);
    }
    // session(['ids_livre' => []])
    // session()->push('ids_livre', 'id')

    public function listCommandesUser($id) {

        $commandes = Commande::where('adh_id', $id)->get();

        return view('consulter-commandes', ['commandes' => $commandes]);
    }

    public function validateCommande(Request $request) {

        $user = Auth::user();
        $panier = Panier::where('adh_id', $user->adh_id)->get();

        $adh_id = $user->adh_id;
        $rel_id = null;
        $adr_id = null;
        $mag_id = null;
        $com_date = date('Y-m-d');

        if ($request->has('option-livraison')) {
            $val = $request->input('option-livraison');

            switch ($val) {
                case "domicile":
                    $adr_id = $user->adresse->adr_id;
                    break;

                case "magasin":
                    $mag_id = $user->mag_id;
                    break;

                case "relais":
                    $rel_id = $user->relaisAdherent->rel_id;
                    break;
            }

        } else {
            // error, todo redirect
        }

        // create commande
        $comm = Commande::create([
            'adh_id'    => $adh_id,
            'rel_id'    => $rel_id,
            'adr_id'    => $adr_id,
            'mag_id'    => $mag_id,
            'com_date'  => $com_date
        ]);
        
        foreach ($panier as $row) {
            LigneCommande::create([
                'com_id'        => $comm->com_id,
                'liv_id'        => $row->liv_id,
                'lec_quantite'  => $row->liv_quantite
            ]);

            //update stock
            
            $liv = Livre::find($row->liv_id);
            $new_qte = $liv->liv_stock - $row->liv_quantite;
            // $liv->save();
            Livre::find($row->liv_id)
                ->update(['liv_stock' => $new_qte]);
            
        }

        Panier::where('adh_id', $adh_id)->delete();

        return redirect()->route('listCommandesUser', ['id' => Auth::user()->adh_id])->with('status', 'Nouvelle commande ajoutée');
    }

    public function confirmationCommande() {
        $user = Auth::user();
        $panier = Panier::where('adh_id', $user->adh_id)->get();

        $livres = [];
        $total_price = 0;

        foreach ($panier as $row) {
            $l = $row->livre;
            $l->attributes['qte'] = $row->liv_quantite;
            $livres[] = $l;
            $total_price += $row->liv_quantite * $l->liv_prixttc;
        }

        return view('validate_commande', ['livres' => $livres, "user" => $user, "totalprice" => $total_price]);
    }
}
