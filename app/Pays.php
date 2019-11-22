<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $table = 't_r_pays_pay';
    protected $primaryKey = 'pay_id';
    public $timestamps = false;
}
