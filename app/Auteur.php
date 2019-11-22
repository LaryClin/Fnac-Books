<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $table = 't_e_auteur_aut';
    protected $primaryKey = 'aut_id';

    public $attributes;
    public $books;

    public function getBooks() {

        $all = Livre::join("t_j_auteurlivre_aul", "t_j_auteurlivre_aul.liv_id", '=', "t_e_livre_liv.liv_id")
            ->join("t_r_format_for", "t_r_format_for.for_id", "=", "t_e_livre_liv.for_id")
            ->join("t_e_editeur_edi", "t_e_editeur_edi.edi_id", "=", "t_e_livre_liv.edi_id")
            ->where("t_j_auteurlivre_aul.aut_id", $this->attributes['aut_id'])
            ->get();

        $this->books = $all;
    }
}
