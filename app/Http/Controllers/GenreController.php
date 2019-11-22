<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use App\Livre;

class GenreController extends Controller
{
    public function index()
    {
        $gs = Genre::paginate(10);
        foreach ($gs as $g) {
            $g->used = Genre::genreStillUsed($g->gen_id);
            if($g->used)
                $g->classTag = "disabled";
            else
                $g->classTag = "";
        }
    	return view('genre-insert', ['genres' => $gs]);
    }

    public function save(Request $request)
    {
    	$pattern = "/^[A-Z][a-z]+$/";
    	$libelle = $request->input('libelle');
    	$libelle = ucfirst(trim($libelle));
    	if(empty($libelle) && !preg_match($pattern, $libelle))
    		return redirect('genre')->withInput()->with('error', 'Il y a une erreur de saisie !');

    	$g = new Genre;
    	$g->timestamps = false;
    	$g->gen_libelle = $libelle;
    	$g->save();

    	return redirect('genre')->with('status', $libelle .' est désormais un nouveau genre.');
    }

    public function genreStillUsed($id)
    {
        return response()->json(['genreStillUsed' => Genre::genreStillUsed($id)]);
    }

    public function deleteGenre($id)
    {
        // Delete
        $genre = Genre::find($id);
        $genre->delete();
        return response()->json(['genre' => $id]);
    }

    public function modifyGenre(Request $request)
    {
        // Récupération des informations du POST
        $libelle = $request->input("libelle");
        $id = $request->input("id");

        //Récupération de la donnée en BDD
        $genre = Genre::find($id);
        $libelle = ucfirst(trim($libelle));

        // S'il y'a bien une donnée : Modification et sauvegarde
        if($genre)
        {
            $genre->gen_libelle = $libelle;
            $genre->timestamps = false;
            $genre->save();
        }

        // Renvoie d'un ok
        return response()->json(["ok" => $libelle]);
    }
}
