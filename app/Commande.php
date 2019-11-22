<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 't_e_commande_com';
    protected $primaryKey = 'com_id';
    protected $fillable = ['adh_id', 'rel_id', 'adr_id', 'mag_id', 'com_date'];
    protected $updated_at;
    protected $created_at;

    public static function IdJoined($id)
    {
    	$commandes = Commande::where('t_e_commande_com.com_id', '=', $id)
    	->leftjoin('t_e_livraison_cli', 't_e_livraison_cli.com_id', '=', 't_e_commande_com.com_id')
    	->leftjoin('t_j_lignecommande_lec', 't_j_lignecommande_lec.com_id', '=', 't_e_commande_com.com_id')
    	->leftjoin('t_e_livre_liv', 't_e_livre_liv.liv_id', '=', 't_j_lignecommande_lec.liv_id')
    	->leftjoin('t_e_adherent_adh', 't_e_adherent_adh.adh_id', '=', 't_e_commande_com.adh_id')
    	->leftjoin('t_e_adresse_adr', 't_e_adresse_adr.adr_id', '=', 't_e_commande_com.adh_id')
    	->leftjoin('t_r_pays_pay', 't_e_adresse_adr.pay_id', '=', 't_r_pays_pay.pay_id')
    	->leftjoin('t_r_magasin_mag', 't_r_magasin_mag.mag_id', '=', 't_e_commande_com.mag_id')
    	->orderBy('com_date', 'desc')
    	->paginate(5);
    	return $commandes;
    }

    public static function AllJoined()
    {
    	$commandes = Commande::join('t_j_lignecommande_lec', 't_j_lignecommande_lec.com_id', '=', 't_e_commande_com.com_id')
    	->leftjoin('t_e_livre_liv', 't_e_livre_liv.liv_id', '=', 't_j_lignecommande_lec.liv_id')
    	->leftjoin('t_e_adherent_adh', 't_e_adherent_adh.adh_id', '=', 't_e_commande_com.adh_id')
    	->leftjoin('t_e_adresse_adr', 't_e_adresse_adr.adr_id', '=', 't_e_commande_com.adh_id')
    	->leftjoin('t_r_pays_pay', 't_e_adresse_adr.pay_id', '=', 't_r_pays_pay.pay_id')
    	->leftjoin('t_r_magasin_mag', 't_r_magasin_mag.mag_id', '=', 't_e_commande_com.mag_id')
    	->orderBy('com_date', 'desc')
    	->get()
    	;
    	return $commandes;
    }
    public static function idAdhJoined($id)
    {
        $commandes = Commande::where('t_e_commande_com.adh_id', '=', $id)
        ->leftjoin('t_j_lignecommande_lec', 't_j_lignecommande_lec.com_id', '=', 't_e_commande_com.com_id')
        ->leftjoin('t_e_livre_liv', 't_e_livre_liv.liv_id', '=', 't_j_lignecommande_lec.liv_id')
        ->leftjoin('t_e_adherent_adh', 't_e_adherent_adh.adh_id', '=', 't_e_commande_com.adh_id')
        ->leftjoin('t_e_adresse_adr', 't_e_adresse_adr.adr_id', '=', 't_e_commande_com.adh_id')
        ->leftjoin('t_r_pays_pay', 't_e_adresse_adr.pay_id', '=', 't_r_pays_pay.pay_id')
        ->leftjoin('t_r_magasin_mag', 't_r_magasin_mag.mag_id', '=', 't_e_commande_com.mag_id')
        ->orderBy('com_date', 'desc')
        ->get()
        ;
        return $commandes;
    }

    public static function WithAdherent()
    {
    	$commandes = Commande::join('t_e_adherent_adh', 't_e_adherent_adh.adh_id', '=', 't_e_commande_com.adh_id')
    	->join('t_e_adresse_adr', 't_e_adresse_adr.adr_id', '=', 't_e_commande_com.adh_id')
    	->join('t_r_pays_pay', 't_e_adresse_adr.pay_id', '=', 't_r_pays_pay.pay_id')
    	->orderBy('com_date', 'desc')
    	->paginate(10);
    	return $commandes;
    }

    public function adherent() {
        return $this->belongsTo('App\User', 'adh_id');
    }

    public function relais() {
        return $this->belongsTo('App\Relais');
    }

    public function adresse() {
        return $this->belongsTo('App\Address');
    }

    public function magasin() {
        return $this->belongsTo('App\Magasin', 'mag_id', 'mag_id');
    }
}
