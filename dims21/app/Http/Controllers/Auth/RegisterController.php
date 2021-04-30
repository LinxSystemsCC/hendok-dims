<?php

namespace App\Http\Controllers\Auth;

use App\TblCustomers;
use App\User;
use App\Registration;
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
    //protected $redirectTo = '/registered';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $user = Registration::on('sqlsrv')->find(1);
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      /*  $create =DB::connection('sqlsrv3')->select("select count(*) as aggregate from tblDIMSUSERS where [UserName] ='".$data['name']."'");
        if (intval($create[0]->aggregate) == 0) {

            $id = DB::connection('sqlsrv3')->insert("insert into tblDIMSUSERS ([PastelUser], [Email],
 [UserName],[Password], [strField6])
values (0,'".$data['email']."','".$data['name']."','".$data['password']."','".bcrypt($data['password'])."')");
        }else{
           // dd();
            return view ( 'auth.login' )->withDetails($create)->withQuery('There is already a record related to these credentials ,Please Login!' );
        }*/
        return TblCustomers::create([
            'UserName' => $data['name'],
            'Email' => $data['email'],
            'Password' => $data['password'],
            'strField6' => bcrypt($data['password']),
        ]);
    }
}
