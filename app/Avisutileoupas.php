<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avisutileoupas extends Model
{
    protected $table = 't_j_avisutileoupas_avu';
    protected $primaryKey = ['avi_id', 'adh_id'];
    
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['avi_id', 'adh_id', 'avu_utile'];

    public static function myAvisUtile($avi_id, $adh_id)
    {
    	return Avisutileoupas::where('avi_id', $avi_id)
    	->where('adh_id', $adh_id)
    	->first();
    }

    public static function myAvisUtileExist($avi_id, $adh_id)
    {
    	return Avisutileoupas::where('avi_id', $avi_id)
    	->where('adh_id', $adh_id)
    	->exists();
    }

    public static function addOrUpdateMyAvisUtile($avi_id, $adh_id, $utile)
    {
        if(!Avisutileoupas::myAvisUtileExist($avi_id, $adh_id))
        {
            $avis = new Avisutileoupas();
            $avis->avi_id = $avi_id;
            $avis->adh_id = $adh_id;
            $avis->avu_utile = $utile;
            $avis->save();
        }
        else
        {
    	   Avisutileoupas::where('avi_id', $avi_id)
           ->where('adh_id', $adh_id)
           ->update(['avu_utile' => $utile]); 
        }
    }

    public static function getAvisUtileOui($avi_id)
    {
        return Avisutileoupas::where('avi_id', $avi_id)
        ->where('avu_utile', '1')
        ->count();
    }

    public static function getAvisUtileNon($avi_id)
    {
        return Avisutileoupas::where('avi_id', $avi_id)
        ->where('avu_utile', '0')
        ->count();
    }
}
