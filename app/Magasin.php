<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $table = 't_r_magasin_mag';
    protected $primaryKey = 'mag_id';
    public $timestamps = false;

    public function commandes() {
    	return $this->belongsToMany('App\Commande', 'mag_id', 'mag_id');
    }
}
