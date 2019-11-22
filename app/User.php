<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $rememberTokenName = false;

    protected $table = "t_e_adherent_adh";
    public $timestamps = false;
    protected $primaryKey = "adh_id";

    protected $fillable = [
        'adh_numadherent', 'adh_datefinadhesion', 'adh_mel', 'adh_motpasse', 'adh_pseudo', 'adh_civilite', 'adh_nom', 'adh_prenom', 'adh_telfixe', 'adh_telportable', 'mag_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'adh_motpasse', 'remember_token',
    ];

    public function getAuthPassword() {
        return $this->adh_motpasse;
    }

    public function roleadherent() {
        return $this->hasOne('App\RoleAdherent', 'adh_id');
    }

    public function hasRelation($key) {
        
        if ($this->relationLoaded($key)) {
            return true;
        }

        if (method_exists($this, $key)) {
            return true;
        }

        return false;
    }

    public function isCustomerService() {
        return $this->roleadherent->attributes['rol_id'] == 4;
    }

    public function isAdmin() {
        return $this->roleadherent->attributes['rol_id'] == 1;
    }

    public function isSaleService() {
        return $this->roleadherent->attributes['rol_id'] == 5;
    }

    public function isCommunicationService() {
        return $this->roleadherent->attributes['rol_id'] == 3;
    }

    public function isEmployee() {
        return ($this->roleadherent->attributes['rol_id'] != null &&
            $this->roleadherent->attributes['rol_id'] != 2);
    }

    public function commandes() {
        return $this->hasMany('App\Commande', 'adh_id');
    }

    public function magasin() {
        return $this->belongsTo('App\Magasin', 'mag_id');
    }

    public function relaisAdherent() {
        return $this->hasOne('App\RelaisAdherent', 'adh_id');
    }

    public function adresse() {
        return $this->hasOne('App\Address', 'adh_id');
    }
}
