<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\RoleAdherent;
use App\Role;
use App\User;

class AdminController extends Controller
{
    public function index() {
    	
    	$user = Auth::user();
    	$role =  $user->roleadherent->getRole();

    	return view('display_admin_options', ["role" => $role]);
    }

    public function listUsers() {
    	
    	$users = User::paginate(10);
    	foreach ($users as $a) {
    		if ($a->hasRelation('roleadherent') && $a->roleadherent != null) {
    			$a->roleadherent->getRole();
    		}
    	}

    	$roles = Role::all();
    	return view('admin_users', ["users" => $users, "roles" => $roles]);
    }

    public function updateRole($adh_id, $rol_id) {

        RoleAdherent::where('adh_id', $adh_id)
            ->update(['rol_id' => $rol_id]);

        return response()->json();

    }
}
