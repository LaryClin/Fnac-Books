<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Address;
use App\Pays;
use App\Magasin;
use App\Relais;
use App\RelaisAdherent;
use App\RoleAdherent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $pays = Pays::all();
        $magasins = Magasin::all();
        $relais = Relais::all();

        $viewParams = [
            'pays' => $pays,
            'magasins' => $magasins,
            'relais' => $relais
        ];

        return view('auth.register', $viewParams);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'adh_nom' => 'required|string|max:50',
            'adh_prenom' => 'required|string|max:50',
            'adh_mel' => 'required|string|email|max:255|unique:t_e_adherent_adh',
            'adh_motpasse' => 'required|string|min:6|confirmed',
            'adh_civilite' => 'required|string|in:M.,Mme,Mlle',
            'adh_pseudo' =>'required|string|max:20',
            'adh_telportable' => ['nullable', 'string', 'max:15', 'required_without:adh_telfixe', 'regex:/^(06|07|041|039|034|044)[0-9]{8,9}$/'],
            'adh_telfixe' => ['nullable', 'string', 'max:15', 'required_without:adh_telportable','regex:/^(04|09)[0-9]{8,9}$/'],
            'mag_id' => 'required|exists:t_r_magasin_mag,mag_id',

            //ADRESSE
            'adr_nom' => 'required|string|max:50',
            'adr_type' => 'required|string|max:15',
            'adr_rue' => 'required|string|max:255',
            'adr_complementrue' => 'nullable|string|max:200',
            'adr_cp' => 'required|string|regex:/^[0-9]{5,5}$/',
            'adr_ville' =>'required|string|max:100',
            'pay_id' => 'required|integer|exists:t_r_pays_pay,pay_id'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $adherent = User::create([
            'adh_civilite'          => $data['adh_civilite'],
            'adh_nom'               => $data['adh_nom'],
            'adh_prenom'            => $data['adh_prenom'],
            'adh_pseudo'            => $data['adh_pseudo'],
            'adh_mel'               => $data['adh_mel'],
            'adh_motpasse'          => bcrypt($data['adh_motpasse']),
            'adh_telfixe'           => $data['adh_telfixe'],
            'adh_telportable'       => $data['adh_telportable'],
            'adh_numadherent'       => rand(1000000000, 9999999999), //Aléatoire
            'adh_datefinadhesion'   => date('Y-m-d', strtotime('+1 year')), 
            'mag_id'                => $data['mag_id']
        ]);

        $adresse = Address::create([
            'adh_id'                => $adherent->adh_id,
            'adr_nom'               => $data['adr_nom'],
            'adr_type'              => /*$data['adr_type']*/"Facturation",
            'adr_rue'               => $data['adr_rue'],
            'adr_complementrue'     => $data['adr_complementrue'],
            'adr_cp'                => $data['adr_cp'],
            'adr_ville'             => $data['adr_ville'],
            'adr_latitude'          => /*$data['adr_latitude']*/ 100351451,
            'adr_longitude'         => /*$data['adr_longitude']*/ 100351451,
            'pay_id'                => $data['pay_id'],
        ]);

        $RelaisAdherent = RelaisAdherent::create([
            'rel_id'                => $data['rel_id'],
            'adh_id'                => $adherent->adh_id,
        ]);
        
        /*
        $roleadherent = RoleAdherent::create([
            'rol_id'                => 2, // default: Customer
            'adh_id'                => $adherent->adh_id
        ]);
        */

        

        DB::table('t_j_roleadherent_rad')->insert(
            ['rol_id' => 2, 'adh_id' => $adherent->adh_id]
        );

        

        return $adherent;

    }
}
