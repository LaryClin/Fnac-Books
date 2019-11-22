<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Livre;
use App\Photo;
use App\Auteur;
use App\AuteurLivre;
use App\Panier;

class PanierController extends Controller
{
    /* MAXIME

    function addPanier(Request $request){
        // -----Récupération des données----- 
        $id = $request->input('id');
        $qte = $request->input('qte');

        // ------Insertion des données dans la variable session----- 
        if(session('ids_livre') != null && session('qtes_livre')!=null){
            session()->push('ids_livre', $id);
            session()->push('qtes_livre', $qte); 
        }
        else
        {
            session(['ids_livre' => []]);
            session(['qtes_livre' => []]);
            session()->push('ids_livre', $id);
            session()->push('qtes_livre', $qte);
        }
    }

    public function removePanier($id) {
        $ids = session('ids_livre');
        dump(session());
        session()->pull('ids_livres');
        dump(session());
        echo("id :");
        dump($ids);
        echo($id);
        foreach ($ids as $key => $value) {
            
            if ($value == $id) {
                unset($ids[$key]);
            }
            else{
                echo("value : ");
                dump($value);
                session()->push('ids_livres', $value);
            }
            
        }
        echo("id");
        dump($ids);
        echo("session");
        dump(session('ids_livres'));
        // return view('panier',["quantite"=>$qtes,"id_livres"=>$ids,"livres"=>$livres, "photos"=>$photos]);
    }

    function consulterPanier(){
        // -----Récupération des données-----
        $qtes = session('qtes_livre');
        $ids = session('ids_livre');
        dump($ids);
        dump($qtes);
        $livres = Livre::all();
        // dump($livres);
        $photos = Photo::all();

        //------Affichage de la vue et envoie des données dans la vue------
        //return view('panier',["quantite"=>$qtes,"id_livres"=>$ids,"livres"=>$livres, "photos"=>$photos]);
    }
    */

    public function addPanier(Request $request){

        $id = intval($request->input('id'));
        $qte = intval($request->input('qte'));

        $stock = Livre::find($id)->liv_stock; 

        $added = false;
        if ($qte > 0 && $qte <= $stock) {

            if (Auth::check()) {
                $panier = Panier::where('adh_id', Auth::user()->adh_id)
                    ->where('liv_id', $id)->first();
                if ($panier == null || ($panier->liv_quantite + $qte) <= $stock) {
                    self::updatePanier(Auth::user()->adh_id, $id, $qte);
                    $added = true;
                }
            } else {

                self::initPanier();
                $panier = session("panier");
                if (array_key_exists($id, $panier)) {
                    $panier[$id] += $qte;
                } else {
                    $panier[$id] = $qte;
                }

                $added = true;
                session()->put("panier", $panier);
                
            }
        }

        return response()->json(['added' => $added]);
    }

    public function modifyQte($liv_id, $new_qte) {

        $modified = false;
        if (self::hasStock($liv_id, $new_qte)) {

            if (Auth::check()) {

                $adh_id = Auth::user()->adh_id;
                self::setPanier($adh_id, $liv_id, $new_qte);
                $modified = true;

            } else {
                self::initPanier();
                $panier = session('panier');

                if (array_key_exists($liv_id, $panier)) {
                    $panier[$liv_id] = $new_qte;
                    session()->put('panier', $panier);
                    $modified = true;
                }
            }
        }

        return response()->json(["modified" => $modified]);
    }

    public function removePanier($id) {

        if (Auth::check()) {
            $adh_id = Auth::user()->adh_id;
            Panier::where('adh_id', $adh_id)->where('liv_id', $id)->delete();
        } else {
            $panier = session("panier");

            if (array_key_exists($id, $panier)) {
                unset($panier[$id]);
            }

            session()->put('panier', $panier);
        }
        
        return response()->json();
    }

    public function consulterPanier(){

        $livres = [];
        $total_price = 0;

        if (Auth::check()) {
            $adh_id = Auth::user()->adh_id;
            $panier = Panier::where('adh_id', $adh_id)->get();
            foreach ($panier as $row) {
                $l = $row->livre;
                $l->attributes['qte'] = $row->liv_quantite;
                $livres[] = $l;
                $total_price += $l->liv_prixttc * $row->liv_quantite;
            }
        } else {
            self::initPanier();

            $panier = session('panier'); // [ liv_id => qte ]
            // dump($panier);

            foreach (Livre::all() as $l) {
                if (array_key_exists($l->liv_id, $panier)) {
                    $l->attributes['qte'] = $panier[$l->liv_id];
                    $livres[] = $l;
                    $total_price += $l->liv_prixttc * $panier[$l->liv_id];
                }
            }
        }

        //dump($livres);

        return view('display_panier', ["livres" => $livres, "total_price" => $total_price]);
    }

    public function empty() {
        if(session()->has('panier') && session('panier') != null){
            session()->put("panier", []);
        }

        return redirect()->route('panier');
    }

    public static function hasStock($liv_id, $qte) {
        $livre = Livre::find($liv_id);
        return $livre->liv_stock >= $qte;
    }

    public static function initPanier() {
        if(!session()->has('panier') || session('panier') == null){
            session()->put("panier", []);
        }
    }

    public function panierRecordExists($adh_id, $liv_id) {
        $row = Panier::where('adh_id', $adh_id)
        ->where('liv_id', $liv_id)->first();
        return $row != null;
    }

    private function setPanier($adh_id, $liv_id, $new_qte) {
        $row = Panier::where('adh_id', $adh_id)
        ->where('liv_id', $liv_id)->first();
        if ($row != null) {

            // exists, update
            $row = Panier::where('adh_id', $adh_id)
            ->where('liv_id', $liv_id)
            ->update(['liv_quantite' => $new_qte]);
            

        } else {
            // not exists, insert
            $p = new Panier();
            $p->adh_id = $adh_id;
            $p->liv_id = $liv_id;
            $p->liv_quantite = $new_qte;
            $p->save();
        }

        return response()->json();
    }

    private function updatePanier($adh_id, $liv_id, $to_add_qte) {
        $new_qte = $to_add_qte;
        $row = Panier::where('adh_id', $adh_id)
        ->where('liv_id', $liv_id)->first();
        if ($row != null) {
            $new_qte = $row->liv_quantite + $to_add_qte;
        }

        self::setPanier($adh_id, $liv_id, $new_qte);
    }

    public function sessionToDb() {
        // auth required
        $adh_id = Auth::user()->adh_id;
        self::initPanier();

        $panier = session('panier');
        foreach ($panier as $key => $val) {
            self::updatePanier($adh_id, $key, $val);
        }

        session()->put("panier", []);

        return redirect()->route('panier');
    }

}
