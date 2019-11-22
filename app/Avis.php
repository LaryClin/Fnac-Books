<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table = 't_e_avis_avi';
    protected $primaryKey = 'avi_id';

    public static function alertJoined($id)
    {
    	$data = Avis::where("t_e_avis_avi.avi_id", $id)
    	->join('t_j_avisabusif_ava', 't_j_avisabusif_ava.avi_id', '=', 't_e_avis_avi.avi_id')
    	->get();

    	return $data;
    }

    public static function isAuthedAvisExist($adh_id, $liv_id)
    {
    	return Avis::where('adh_id', $adh_id)
    	->where('liv_id', $liv_id)->exists();
    }

    public static function myAvis($adh_id, $liv_id)
    {
    	return Avis::where('adh_id', $adh_id)
    	->where('liv_id', $liv_id)->first();
    }
}
