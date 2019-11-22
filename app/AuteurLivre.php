<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AuteurLivre extends Model
{
    protected $table = 't_j_auteurlivre_aul';
    protected $primaryKey = ['liv_id', 'aut_id'];

    public $attributes;

    public static function getAuteurLivreCombo($obj = []) {
        $all = DB::table("t_e_livre_liv")
            ->join("t_j_auteurlivre_aul", "t_j_auteurlivre_aul.liv_id", '=', "t_e_livre_liv.liv_id")
            ->join("t_e_auteur_aut", "t_e_auteur_aut.aut_id", '=', "t_j_auteurlivre_aul.aut_id");
            
        foreach ($obj as $o) {
        	$all = $all->where($o[0], $o[1]);
        }

        $all = $all->get();

        $combo = [];
        
        foreach ($all as $e) {
        	$combo[] = $e;
        }

        return $combo;
    }
}
