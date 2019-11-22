<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avisabusif extends Model
{
    protected $table = 't_j_avisabusif_ava';
    protected $primaryKey = ['avi_id', 'adh_id'];
    
    public $timestamps = false;
    public $incrementing = false;

    public static function allJoined()
    {
    	$data = Avisabusif::join('t_e_avis_avi', 't_e_avis_avi.avi_id', '=', 't_j_avisabusif_ava.avi_id')
    	->join('t_e_adherent_adh', 't_e_adherent_adh.adh_id', '=', 't_j_avisabusif_ava.adh_id')
    	->orderBy('t_e_avis_avi.avi_id')
    	->get();
    	return $data;
    }
}
