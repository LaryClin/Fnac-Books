<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Livre;

class ComparateurController extends Controller
{
    public function add(Request $request, $id) {
    	if (!self::isCompare($id)) {
            $full = self::isFull();

            if (!$full) {
              $livre = Livre::join('t_e_photo_pho', 't_e_photo_pho.liv_id', '=', 't_e_livre_liv.liv_id')
                ->where('t_e_livre_liv.liv_id', $id)
                ->get();
                $request->session()->push('livres', $livre[0]);
            }
    		
            return response()->json(["full" => $full]);
       } else {
    		// already in
       }

    	/*
		echo "<pre>";
    	var_dump(session()->get("livres"));
    	echo "</pre>";
    	*/

    	
    }

    public function remove($id) {
        $livres = session()->pull('livres', []);
        $removed = null;

        foreach ($livres as $key => $l) {
            if ($l->liv_id == $id) {
                $removed = $l->toJson();
                var_dump($livres[$key]);
                unset($livres[$key]);
            }
        }

        session()->put('livres', $livres);
        //return response()->json(["livres" => $removed]);
    }

    public function empty() {
    	session(['livres' => []]);

    	/*
    	echo "<pre>";
    	var_dump(session()->get("livres"));
    	echo "</pre>";
    	*/
    }

    public function get(){
    	$livres = session()->get("livres");
        return response()->json(["livres" => $livres]);
    }

    public function show() {

    	self::setup();
    	return view('display_comparateur', ["livres" => session()->get('livres'), "url" => url('/')]);
    }

    public static function setup() {
    	if (!session()->has('livres')) {
           session(['livres' => []]);
        }
    }

    public static function isCompare($id) {
        $isCompare = false;
        self::setup();
        foreach (session()->get('livres') as $livre) {
            if ($livre->liv_id == $id) {
                $isCompare = true;
            }
        }
        return $isCompare;
    }

    public static function isFull() {
        self::setup();
        return count(session()->get('livres')) >= 3;
    }
}
