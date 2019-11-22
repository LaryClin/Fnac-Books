<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avisabusif;
use App\Avis;

class AvisAbusifController extends Controller
{
    public function showAll()
    {
    	$avisabusifs = Avisabusif::allJoined();
    	//dump($avisabusifs);
    	return view('all-avisabusif', ["all" => $avisabusifs, "test" => "kool"]);
    }

    public function delete($id)
    {
    	$avisabusifs = Avis::alertJoined($id);

    	foreach ($avisabusifs as $key => $avi) {
    		Avisabusif::where('avi_id', $avi->avi_id)
    		->where('adh_id', $avi->adh_id)->delete();
    	}
    	Avis::where('avi_id', $id)->delete();

    	return back()->with('succes', 'L\'avis a été supprimé.');
    }

    public function deleteSignalement(Request $req)
    {
    	$avi_id = $req->input('avi_id');
    	$adh_id = $req->input('adh_id');

    	Avisabusif::where('avi_id', $avi_id)
    		->where('adh_id', $adh_id)->delete();

    	return back()->with('succes', 'Le signalement a été supprimé.');
    }
}
