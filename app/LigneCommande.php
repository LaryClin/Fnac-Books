<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $table = 't_j_lignecommande_lec';
    //protected $primaryKey = array("com"=>'com_id',"livre"=> 'liv_id');
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['com_id', 'liv_id', 'lec_quantite'];
    protected $updated_at;
    protected $created_at;

    public function livre() {
    	return $this->hasOne('App\Livre', 'liv_id', 'liv_id');
    }

    public function commande() {
    	return $this->hasOne('App\Commande', 'com_id', 'com_id');
    }
}
