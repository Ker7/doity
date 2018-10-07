<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect;

use App\User as User;
use App\Field as Field;
use App\UserField as UserField;

use Illuminate\Support\Facades\Route as Route;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('profile');
    }
    
    public function updateProfile(){
        $this->displayGet();
        if ( null !== (Input::get('form_name'))) {
            //Auth::user()->setName(Input::get('name'));
            $u = User::findOrFail(Auth::user()->id);
            //print_r($u);
            //$u->setName(Input::get('name'));
            
            //return redirect()->action('HomeController@index');
            return redirect()->action('ProfileController@index');
        } else {
        // ELSE ERROR ERROR
            echo "ProfileController updateProfile() error :: no input";
        }
    }
    
    // HELPER FUNCTIONS //  
    private function displayMeth(){
        $route = Route::current();
        $name = $route->getName();
        $actionName = $route->getActionName();
        echo "".$name."@".$actionName;
    }
    
    private function displayGet(){
        echo "<pre>";
        print_r (Input::get());
        echo "</pre>";
    }
}
