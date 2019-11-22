<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Livre;
use App\Photo;

class PhotoController extends Controller
{
    public function showListBooks(Request $request) {
    	$all = Livre::myWhere();

    	foreach ($all as $b) {
    		$b->getAuthor();
    	}

    	//dump($all[0]->photos);
    	return view('display_photo_list', ["books" => $all]);
    }

    public function showPhotos($id, Request $request) {
    	$livre = Livre::find($id);
    	$photos = $livre->photos;

    	//dump($livre);

    	return view('display_photo', ['livre' => $livre, "photos" => $photos]);
    }

    public function add(Request $request, $id) {
        
        // SAVE
        $photo = new Photo();
        $photo->liv_id = $id;
        $filename = $request->new_photo->store('public');
        $photo->pho_url = "/storage/" . pathinfo($filename)['basename'];
        $photo->save();

        return redirect('/photos/' . $id);
    }

    public function delete(Request $request, $id) {
        $photo = Photo::find($id);
        if ($photo != null) {
            Storage::delete('/storage/' . $photo->pho_url);
            $photo->delete();
        }

        return response()->json();
    }

    public function debug() {
        dump(storage_path('app/public'));
        dump(env('APP_URL').'/storage');
    }
}
