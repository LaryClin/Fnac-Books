<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelaisAdherent extends Model
{
    protected $table = 't_j_relaisadherent_rea';
    protected $primaryKey = ['rel_id', 'adh_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'rel_id', 'adh_id'
    ];

    public function adherent() {
    	return $this->belongsTo('App\User', 'adh_id');
    }

    public function relais() {
    	return $this->belongsTo('App\Relais', 'rel_id');
    }
}
