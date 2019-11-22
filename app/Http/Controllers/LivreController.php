<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Livre;
use App\Photo;
use App\Avis;
use App\User;
use App\Favori;
use App\Avisabusif;
use App\Avisutileoupas;

use App\Http\Controllers\ComparateurController;

class LivreController extends Controller
{
    /*public function index()
    {
    	$books = Livre::all();
        return view('search', ["books" => $books]);
    }*/

    public function consulter($id)
    {
    	$livre = Livre::find($id);
    	$photos = Photo::all();
    	$avis = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
            ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
            ->where("t_e_avis_avi.liv_id", $id)
            ->paginate(5);
        $adherents = User::all();
    	if (isset($photos)) {
            $photos = Photo::where('liv_id',$id)->get();
        }
        View::share("avis",$avis);
        View::share("adherents",$adherents);

        $in_comparator = ComparateurController::isCompare($id);

        $alreadyBought = false;

        if(Auth::check() && Livre::alreadyBought($livre->liv_id, Auth::id()))
        {
            $alreadyBought = true;
        }

        // check if book is in favorite
        $inFav = false;
        $isAuthedAvisExist = false;
        $myAvis = null;
        $myAvisUtileExist = false;
        $myAvisUtile = null;
        if (Auth::check()) {
            $user = Auth::user();
            $adh_id = $user['adh_id'];
            $inFav = Favori::isFavorite($id, $adh_id);
            $isAuthedAvisExist = Avis::isAuthedAvisExist(Auth::id(), $livre->liv_id);
            if($isAuthedAvisExist)
            {
                $myAvis = Avis::myAvis(Auth::id(), $livre->liv_id);
            }
        }

        // Signalement
        if(Auth::check())
        {
            $aviabusifs = Avisabusif::where('adh_id', Auth::id())->get();
            foreach ($aviabusifs as $keya => $aviabusif) {
                foreach ($avis as $keyb => $avi) {
                    if(!$avis[$keyb]->alreadySignaled)
                    {
                        if($aviabusif->adh_id == $avi->adh_id || 
                            ($avi->avi_id == $aviabusif->avi_id && $aviabusif->adh_id == Auth::id()))
                        {
                            $avis[$keyb]->alreadySignaled = true;
                        }
                        else
                        {
                            $avis[$keyb]->alreadySignaled = false;
                        }
                    }
                }
            }

            // Nb avis utile / pas utile
            foreach ($avis as $key => $avi) {
                $avis[$key]->myAvisUtileExist = Avisutileoupas::myAvisUtileExist($avi->avi_id, Auth::id());
                if($avis[$key]->myAvisUtileExist)
                {
                    $avis[$key]->myAvisUtile = Avisutileoupas::myAvisUtile($avi->avi_id, Auth::id());
                }
                $avis[$key]->avi_nbutileoui += Avisutileoupas::getAvisUtileOui($avi->avi_id);
                $avis[$key]->avi_nbutilenon += Avisutileoupas::getAvisUtileNon($avi->avi_id);
            }
        }
    	
    	return view('consulter', [
            "livre" => $livre, 
            "photos" => $photos, 
            "avis"=>$avis, 
            "adherents"=>$adherents, 
            "id" => $id, 
            "url" => url('/'),
            "inComparator" => $in_comparator,
            "fav" => $inFav,
            "authedAvisExist" => $isAuthedAvisExist,
            "myAvis" => $myAvis,
            "alreadyBought" => $alreadyBought
        ]);
    }

    // public function consulter_By_Date()
    // {
    // 	$livres = Livre::where('liv_id', $id)->get();
    // 	$photos = Photo::all();
    // 	$avis = Avis::where('liv_id',$id)->orderBy('avi_date', 'DESC')->get();
    //     $adherents = Adherent::all();
    // 	if (isset($photos)) {
    //         $photos = Photo::where('liv_id',$id)->get();
    //     }
    //     View::share("avis",$avis);
    //     View::share("adherents",$adherents);
    	
    // 	return view('consulter', ["livres" => $livres], ["photos"=>$photos]);
    // }

    // public function consulter_By_Note_And_Date()
    // {
    // 	$livres = Livre::where('liv_id', $id)->get();
    // 	$photos = Photo::all();
    // 	$avis = Avis::where('liv_id',$id)->orderBy('avi_note','ASC')->orderBy('avi_date', 'DESC' )->get();
    //     $adherents = Adherent::all();
    // 	if (isset($photos)) {
    //         $photos = Photo::where('liv_id',$id)->get();
    //     }
    //     View::share("avis",$avis);
    //     View::share("adherents",$adherents);
    	
    // 	return view('consulter', ["livres" => $livres], ["photos"=>$photos]);
    // }

}
