<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        //echo "Mine munni kõik raisk";
        //end;
        
        //dd($request->all());
        $data = $request->all();
        //if (\Config::has('doti-settings.create-user-password') == 1) {
            //if ($data['incode'] == config('doti-settings.create-user-password')) {
                event(new Registered($user = $this->create($request->all())));
                $this->guard()->login($user);
                //return $this->registered($request, $user)
                //                ?: redirect()->action('HomeController@sync');
                return $this->registered($request, $user)
                                ?: redirect($this->redirectPath());
                //return redirect()->action('HomeController@sync'); 
            //}
        //}
        
        //print_r(\Config::has('doti-settings.create-user-password'));
        //dd($data['incode'] == config('doti-settings.create-user-password'));
                        
        return redirect()->action('HomeController@index'); 
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
