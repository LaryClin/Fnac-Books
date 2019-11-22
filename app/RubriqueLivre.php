<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubriqueLivre extends Model
{
    protected $table = 't_j_rubriquelivre_rul';
	protected $primaryKey = ['liv_id', 'rub_id'];

	public $attributes;
}
