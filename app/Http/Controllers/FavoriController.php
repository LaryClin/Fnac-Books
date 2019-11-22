<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Favori;

class FavoriController extends Controller
{
    public function index() {
    	$adh_id = self::getUserID();
    	$livres = Favori::getForAdh($adh_id);
    	foreach ($livres as $l) {
    		$l->getAuthor();
    	}
    	//dump($livres);
    	return view('display_fav', ['livres' => $livres, "url" => url("/")]);
    }

    public function add($id) {
    	$adh_id = self::getUserID();
    	DB::table('t_j_favori_fav')->insert([
		    ['adh_id' => $adh_id, 'liv_id' => $id],
		]);
    }

    public function remove($id) {
    	$adh_id = self::getUserID();

    	Favori::where("liv_id", $id)
    		->where('adh_id', $adh_id)
    		->delete();
    }

    public static function getUserID() {
    	$user = Auth::user();
    	$adh_id = $user['adh_id'];
    	return $adh_id;
    }
}
