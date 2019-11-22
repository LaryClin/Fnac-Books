<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Avis;
use App\Adherent;
use App\Livre;
use App\Avisabusif;
use App\Avisutileoupas;

class AvisController extends Controller
{

    public function index($id)
    {
        $avis = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
        ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
        ->where("t_e_avis_avi.liv_id", $id)
        ->paginate(5);
        return view('display_avis', ["avis" => $avis, "previous" => "/consulter/" . $id]);
    }

    /*
    public function avis($id) 
    { 

        $avis = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
        ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
        ->where("t_e_avis_avi.liv_id", $id)
        ->get();

        return response()->json(["avis" => $avis]);
    }

    public function avis_By_Date($id)
    {
        $avis = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
        ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
        ->where("t_e_avis_avi.liv_id", $id)
        ->orderby('t_e_avis_avi.avi_date','DESC')
        ->get();
        return response()->json(["avis" => $avis]);
    }

    public function avis_By_Date_And_Note($id)
    {
        $avis = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
        ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
        ->where("t_e_avis_avi.liv_id", $id)
        ->orderBy('t_e_avis_avi.avi_note','ASC')
        ->orderby('t_e_avis_avi.avi_date','DESC')

        ->get();
        return response()->json(["avis" => $avis]);
    }
    */

    public function fetch_data($id, Request $req) {

        $avi_date = $req->input('avi_date');
        $avi_note = $req->input('avi_note');
        $liv_id = $req->input('liv_id');

        $data = Avis::select('t_e_avis_avi.avi_titre','t_e_avis_avi.avi_date','t_e_avis_avi.avi_detail','t_e_avis_avi.avi_note','a.adh_pseudo','t_e_avis_avi.avi_id','t_e_avis_avi.avi_nbutileoui','t_e_avis_avi.avi_nbutilenon','a.adh_id','t_e_avis_avi.liv_id')
        ->join("t_e_adherent_adh as a", "t_e_avis_avi.adh_id", '=', "a.adh_id")
        ->where("t_e_avis_avi.liv_id", $id);
        
        if ($avi_note != "")
            $data = $data->orderBy("t_e_avis_avi.avi_note", $avi_note);

        if ($avi_date != "")
            $data = $data->orderBy("t_e_avis_avi.avi_date", $avi_date);
            
        
        $data = $data->paginate(5);

        $myAvis = null;
        $myAvisUtileExist = false;
        $myAvisUtile = null;
        if(Auth::check())
        {
            $isAuthedAvisExist = Avis::isAuthedAvisExist(Auth::id(), $liv_id);
            if($isAuthedAvisExist)
            {
                $myAvis = Avis::myAvis(Auth::id(), $liv_id);
            }


            $aviabusifs = Avisabusif::where('adh_id', Auth::id())->get();
            foreach ($aviabusifs as $keya => $aviabusif) {
                foreach ($data as $keyb => $avi) {
                    if(!$data[$keyb]->alreadySignaled)
                    {
                        if($aviabusif->adh_id == $avi->adh_id || 
                            ($avi->avi_id == $aviabusif->avi_id && $aviabusif->adh_id == Auth::id()))
                        {
                            $data[$keyb]->alreadySignaled = true;
                        }
                        else
                        {
                            $data[$keyb]->alreadySignaled = false;
                        }
                    }
                }
            }

            foreach ($data as $key => $avi) {
                $data[$key]->myAvisUtileExist = Avisutileoupas::myAvisUtileExist($avi->avi_id, Auth::id());
                if($data[$key]->myAvisUtileExist)
                {
                    $data[$key]->myAvisUtile = Avisutileoupas::myAvisUtile($avi->avi_id, Auth::id());
                }
                $data[$key]->avi_nbutileoui += Avisutileoupas::getAvisUtileOui($avi->avi_id);
                $data[$key]->avi_nbutilenon += Avisutileoupas::getAvisUtileNon($avi->avi_id);
            }
        }

        return response()->json(["avis" => $data]);
    }

    public function signaler($id)
    {
        if(Auth::check())
        {
            $ab = new Avisabusif();
            $ab->adh_id = Auth::id();
            $ab->avi_id = $id;
            $ab->save();
        }
        return back()->with('succes', "L'avis a bien été signalé.");
    }

    public function add(Request $request)
    {
        $adh_id = $request->input("adh_id");
        $liv_id = $request->input("liv_id");
        $avi_titre = $request->input("avi_titre");
        $avi_detail = $request->input("avi_detail");
        $avi_note = $request->input("avi_note");
        $avi_nbutileoui = 0;
        $avi_nbutilenon = 0;

        $avis = new Avis();
        $errors = [];

        if(Auth::check())
        {
            if(strlen($avi_titre) > 100)
                $errors[] = "avi_titre";

            if(strlen($avi_detail) > 2000)
                $errors[] = "avi_detail";

            if($avi_note > 5 || $avi_note < 1)
                $errors[] = "avi_note";

            if(!$errors)
            {
                // ajouter
                $avis->adh_id = $adh_id;
                $avis->liv_id = $liv_id;
                $avis->avi_titre = $avi_titre;
                $avis->avi_detail = $avi_detail;
                $avis->avi_note = $avi_note;
                $avis->avi_nbutileoui = $avi_nbutileoui;
                $avis->avi_nbutilenon = $avi_nbutilenon;
                $avis->timestamps = false;
                $avis->save();
            }
            else
                return back()->withInput()->with('errors', $errors);
        }
        return back();
    }

    public function avisUtile(Request $request)
    {
        $avi_id = $request->input('avi_id');
        $adh_id = $request->input('adh_id');
        $utile = $request->input('utile');

        Avisutileoupas::addOrUpdateMyAvisUtile($avi_id, $adh_id, $utile);

        return back();
    }
}
