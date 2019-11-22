<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relais extends Model
{
    protected $table = 't_e_relais_rel';
    protected $primaryKey = 'rel_id';
    public $timestamps = false;

    public function commandes() {
    	return $this->hasMany('App\Commande', 'rel_id');
    }

    public function pays() {
    	return $this->belongsTo('App\Pays', 'rel_id');
    }


}
