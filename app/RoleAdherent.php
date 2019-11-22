<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class RoleAdherent extends Model
{
    protected $table = 't_j_roleadherent_rad';
    protected $primaryKey = ['rol_id', 'adh_id'];
    protected $fillable = ['rol_id', 'adh_id'];
    public $timestamps = false;
    public $attributes;

    public function role() {
    	return $this->belongsTo('App\Role', 'rol_id', 'rol_id');
    }

    public function adherent() {
    	return $this->belongsTo('App\User', 'adh_id', 'adh_id');
    }

    public function getRole() {
    	$role = Role::find($this->attributes['rol_id']);
        $this->attributes['role'] = $role;
    	return $role;
    }
}
