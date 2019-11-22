<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 't_r_genre_gen';
    protected $primaryKey = 'gen_id';

    public static function genreStillUsed($id)
    {
    	$livre = Livre::where('gen_id',$id)->first();
        return !empty($livre);
    }
}
