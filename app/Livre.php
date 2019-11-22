<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
	protected $table = 't_e_livre_liv';
	protected $primaryKey = 'liv_id';
	protected $fillable = ['for_id', 'edi_id', 'gen_id', 'liv_titre', 'liv_histoire', 'liv_dateparution', 'liv_prixttc',
		'liv_isbn', 'liv_stock'];
    protected $updated_at;
    protected $created_at;
    public $timestamps = false;

	public $attributes;
	public $auteurs = [];

	public function getAuthor() {

		$all = Auteur::join("t_j_auteurlivre_aul", "t_j_auteurlivre_aul.aut_id", '=', "t_e_auteur_aut.aut_id")
			->where("t_j_auteurlivre_aul.liv_id", $this->attributes['liv_id'])
			->get();

		$this->auteurs = $all;
	}

	public function photos() {
		return $this->hasMany("App\Photo", 'liv_id', 'liv_id');
	}

	private static function customQuery($tab=[]) {
		$f = new Format;
		$for_table = $f->getTable();
		$for_id = $f->getKeyName();
		$for_str = $for_table . "." . $for_id;
		$livre_for = with(new Livre)->getTable() . ".for_id";

		$e = new Editeur;
		$edi_table = $e->getTable();
		$edi_id = $e->getKeyName();
		$edi_str = $edi_table . "." . $edi_id;
		$livre_edi = with(new Livre)->getTable() . ".edi_id";

		$all = Livre::join($for_table, $for_str, "=", $livre_for)
			->join($edi_table, $edi_str, "=", $livre_edi);

		foreach ($tab as $key => $val) {
			$all = $all->where($key, "=", $val);
		}


		return $all;
	}

	public static function myFind($tab=[]) {
		return self::customQuery($tab)->first();
	}

	public static function myWhere($tab=[]) {
		return self::customQuery($tab)->paginate(10);
	}

	public static function returnKey(){
		$l = new Livre;
		return $l->getKeyName();
	}

	public function ligne_commande() {
		return $this->belongsTo('App\LigneCommande', 'liv_id', 'liv_id');
	}

	public static function alreadyBought($idliv, $idadh)
	{
		return Livre::join('t_j_lignecommande_lec', 't_j_lignecommande_lec.liv_id', '=', 't_e_livre_liv.liv_id')
		->join('t_e_commande_com', 't_e_commande_com.com_id', '=', 't_j_lignecommande_lec.com_id')
		->join('t_e_livraison_cli', 't_e_livraison_cli.com_id', '=', 't_e_commande_com.com_id')
		->where('t_e_livre_liv.liv_id', '=', $idliv)
		->where('t_e_commande_com.adh_id', '=' ,$idadh)->exists();
	}
}
