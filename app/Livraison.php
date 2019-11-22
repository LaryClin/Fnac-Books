<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $table = 't_e_livraison_cli';
    protected $primaryKey = "cli_id";

    public $timestamps = false;
}
