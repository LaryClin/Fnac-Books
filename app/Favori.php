<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Livre;

class Favori extends Model
{
    protected $table = 't_j_favori_fav';
    protected $primaryKey = ["adh_id","liv_id"];

    public static function getForAdh($id) {
    	$livres = Livre::join("t_j_favori_fav", "t_j_favori_fav.liv_id", "=", "t_e_livre_liv.liv_id")
    		->join("t_e_adherent_adh", "t_e_adherent_adh.adh_id", "=", "t_j_favori_fav.adh_id")
    		->join("t_r_format_for", "t_r_format_for.for_id", "=", "t_e_livre_liv.for_id")
    		->join("t_e_editeur_edi", "t_e_editeur_edi.edi_id", "=", "t_e_livre_liv.edi_id")
    		->where("t_e_adherent_adh.adh_id", $id)
    		->paginate(10);

   		return $livres;
    }

    public static function isFavorite($id_liv, $id_adh) {
        $isFav = true;
        $result = Favori::where('t_j_favori_fav.adh_id', $id_adh)
            ->where("t_j_favori_fav.liv_id", $id_liv)
            ->first();
        if ($result === null) {
          $isFav = false;
        }
        return $isFav;
    }
}
