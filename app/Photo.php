<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 't_e_photo_pho';
    protected $primaryKey = 'pho_id';
    protected $updated_at;
    protected $created_at;

    public function livre() {
    	return $this->belongsTo("App\Livre", 'liv_id', 'liv_id');
    }
}
