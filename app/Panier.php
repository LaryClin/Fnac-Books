<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $table = 't_e_panier_pan';
    protected $primaryKey = ['adh_id', 'liv_id'];
    //protected $primaryKey = null;
	public $incrementing = false;

    protected $fillable = ['adh_id', 'liv_id', 'liv_quantite'];
    public $timestamps = false;

    public function adherent() {
    	return $this->belongsTo("App\User", "adh_id");
    }

    public function livre() {
    	return $this->belongsTo("App\Livre", "liv_id");
    }
}
