<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Livre;
use App\Genre;
use App\Editeur;
use App\Format;

use App\Auteur;
use App\AuteurLivre;

use App\Rubrique;
use App\RubriqueLivre;

use App\Http\Controllers\ComparateurController;

define("LEVENSHTEIN_DISTANCE", 2);

class RechercheController extends Controller
{
    public function index()
    {
    	//$books = Livre::all();
        return view('search');
    }

    public function search_by_auteur() {
    	$auteurs = Auteur::all();
    	return view('search_by_auteur', ["auteurs" => $auteurs]);
    }

    public function display_auteur(Request $request) {
    	
        if (!isset($_GET['author_name']) || (empty($_GET['author_name']))) {
            // return error
            header("Location: /search/auteur");
            exit();
        }

        $books = [];
        $author_name = strtolower($_GET['author_name']);

        $auteurs = Auteur::all();
        foreach($auteurs as $aut) {
            if (levenshtein($author_name, strtolower($aut->attributes['aut_nom'])) <= LEVENSHTEIN_DISTANCE || strpos(strtolower($aut->attributes['aut_nom']), $author_name) !== false) {

                $aut->getBooks();

                foreach ($aut->books as $b) {
                    $b->getAuthor();
                    $b['isCompare'] = ComparateurController::isCompare($b->liv_id);
                    $books[] = $b;
                }
            }
        }

        /*
        echo "<pre>";
        var_dump($books);
        echo "</pre>";
        */

        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $_GET['page'];
        }
        $per_page = 10;
        $books = collect($books);

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($books->forPage($page, $per_page), $books->count(), $per_page, $page);

        // set url path for generted links
        $paginatedItems->setPath($request->url() . "?author_name=" . $author_name);
        

        return view('display_books', ["books" => $paginatedItems, "previous" => "/search/auteur","url" => url('/')]);
    }

    public function search_by_rubrique() {
    	$rubriques = Rubrique::all();
    	return view('search_by_rubrique', ["rubriques" => $rubriques]);
    }

    public function display_rubrique($id, Request $request) {

        $books = [];
        $rubrique_livres = RubriqueLivre::where("rub_id", $id)->get();
        foreach ($rubrique_livres as $rl) {
            $id_book = $rl->attributes["liv_id"];

            $tmp = new Livre();
            $key = $tmp->getTable() . ".liv_id";
            $options = [
                $key => $id_book
            ];
            
            //$obj = Livre::find($id_book);
            
            $obj = Livre::myFind($options);
            
            if ($obj != null) {
                $obj->getAuthor();
                $obj['isCompare'] = ComparateurController::isCompare($obj->liv_id);
                $books[] = $obj;
            }

        }

        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $_GET['page'];
        }
        $per_page = 10;
        $books = collect($books);

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($books->forPage($page, $per_page), $books->count(), $per_page, $page);

        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('display_books', ["books" => $paginatedItems, "previous" => "/search/rubrique","url" => url('/')]);
    }

    public function search_by_genre() {
    	$genres = Genre::all();
    	return view('search_by_genre', ['genres' => $genres]);
    }

    public function display_genre($id) {

        $tmp = new Livre();
        $key = $tmp->getTable() . ".gen_id";
        $options = [
            $key => $id
        ];
        $books = Livre::myWhere($options);

        foreach ($books as $b) {
            $b->getAuthor();
            $b['isCompare'] = ComparateurController::isCompare($b->liv_id);
        }

        return view('display_books', ["books" => $books, "previous" => "/search/genre","url" => url('/')]);
    }

    public function search_by_editeur() {

        $editeurs = Editeur::all();
        return view('search_by_editeur', ['editeurs' => $editeurs]);
    }

    public function display_editeur($id) {

        $tmp = new Livre();
        $key = $tmp->getTable() . ".edi_id";
        $options = [
            $key => $id
        ];
        $books = Livre::myWhere($options);

        foreach ($books as $b) {
            $b->getAuthor();
            $b['isCompare'] = ComparateurController::isCompare($b->liv_id);
        }

        return view('display_books', ["books" => $books, "previous" => "/search/editeur","url" => url('/')]);
    }

    public function search_by_format() {

        $formats = Format::all();
        return view('search_by_format', ['formats' => $formats]);
    }

    public function display_format($id) {

        $tmp = new Livre();
        $key = $tmp->getTable() . ".for_id";
        $options = [
            $key => $id
        ];
        $books = Livre::myWhere($options);

        foreach ($books as $b) {
            $b->getAuthor();
            $b['isCompare'] = ComparateurController::isCompare($b->liv_id);
        }

        return view('display_books', ["books" => $books, "previous" => "/search/format","url" => url('/')]);
    }

    public function debug() {

        $tmp = new Livre();
        $key = $tmp->getTable() . ".gen_id";
        $options = [
            $key => 1
        ];

        $books = Livre::myWhere($options);
        echo "<pre>";
        var_dump($books);
        echo "</pre>";

        echo "<h1>LOL</h1>";

        $books2 = Livre::all();
        echo "<pre>";
        var_dump($books2);
        echo "</pre>";

        //return view('display_books', ["books" => $books, "previous" => "/search/genre"]);
    }

    

}
