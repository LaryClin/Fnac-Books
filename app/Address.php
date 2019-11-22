<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 't_e_adresse_adr';
    protected $primaryKey = 'adr_id';
    public $timestamps = false;

    protected $fillable = [
		'adh_id','adr_nom', 'adr_type',
        'adr_rue', 'adr_complementrue',
        'adr_cp', 'adr_ville', 'pay_id',
        'adr_latitude', 'adr_longitude'
    ];

    public function commande() {
    	return $this->belongsTo('App\Commande', 'adr_id', 'adr_id');
    }

    public function pays() {
        return $this->belongsTo('App\Pays', 'pay_id');
    }
}
