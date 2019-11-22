<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 't_e_role_rol';
    protected $primaryKey = 'rol_id';
    public $timestamps = false;

    public function roleadherent() {
    	return $this->hasMany('App\RoleAdherent');
    }
}
