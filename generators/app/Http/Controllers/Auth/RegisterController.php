<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use auth;
use Illuminate\Http\Request;
use Hash;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }





    public function edit(){
      $user = Auth::user();
      return view('auth.edit',compact('user'));
    }

    public function update(Request $request){
      $this->validate($request, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
          'password' => 'min:6|confirmed',
      ]);

      $user = User::find(Auth::id());

      if($request->has('password')){
        $password = Hash::make($request->password);
      }else{
        $password = Auth::user()->password;
      }

      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = $password;
      $user->update();
        return redirect('/')->with('success','User updated...');
    }

}
