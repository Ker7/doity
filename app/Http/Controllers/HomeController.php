<?php

namespace App\Http\Controllers;

use App\Http\Requests;
//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect;

use App\User as User;
use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\Dotilog as Dotilog;
use App\FHabit as FHabit;

use Carbon\Carbon;

use Illuminate\Support\Facades\Route as Route;

class HomeController extends Controller
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


    /**
     * Show the application Home dashboard.
     * Get User Fields and pass to view.
     *a
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $newField = new Field;
        $newHabit = new Habit;
        //$field->name = 'Jukimuki';

        $data = array(
            'userFields' => UserField::where('user_id', Auth::id())
                                        ->where('active', true)         //Retrieve only active fields
                                        ->get(),
            'userFieldsUnactive' => UserField::where('user_id', Auth::id())
                                        ->where('active', false)         //Retrieve nonactive fields
                                        ->get(),
            'openField'  => Input::get('field_id'),
            'specialWelcome' => $this->getWelcomeMessage(),
            'newField' => $newField,
            'newHabit' => $newHabit
            );
        
        // Ajax@home, here shouldn't do much
        if(Request::ajax()){
            echo "ajaxx!";
            $str = "123Ajax@HomeController";
            return $str;//Response::json(Request::all()); 
        }
        
        //echo "<pre>";
        ////print_r(UserField::where('user_id', Auth::id())
        ////                                ->where('active', true)         //Retrieve only active fields
        ////                                ->get());
        //print_r(UserField::where('user_id', Auth::id())
        //                                ->where('active', false)         //Retrieve only active fields
        //                                ->get());
        //echo "</pre>";
        
        return view('home', $data);
    }
    
    /* 
     * Something was $_POST'ed to /Home
     */
    public function postIndex(){
        //$this->displayGet();
        //$this->displayMeth();
        
        if (null !== Input::get('field_id')) {
            $ufid = Input::get('field_id');
            $userField = UserField::findOrFail($ufid); 
            switch(Input::get('form_name')) {
                case('field_clicked'): return $this->processFormFieldClicked($ufid);
                case('field_active'): return $this->processFormFieldActive($ufid);
                case('field_public'): return $this->processFormFieldPublic($ufid);
                default: break;
            }
        }
        return $this->index();
    }
     /*
      * Filters to see selection:
      * dtf - date_from
      * dtt - date_to
      * form_reflect_field - project_id
      * form_reflect_habits - user_id
      * uid - User ID if have privilege
      * 
      */
    public function reflect(){
        
        // TESTING PARAMETER SHOW ONLY!! //
        $this->displayGet();
        //$this->displayMeth();
        // TESTING END //
        
        $data = array();            //data array to be passed to View                              
        $fieldHabits = array();     //a link between a Habit and UserField
        $dotiLogs = array();        //a record of data
        $userSelect = array();      // array of user-id => name's
        
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 7 );

        $get_field_id = Input::get('form_reflect_field');   //If set then use it to display default option in form
        $get_habit_id = Input::get('form_reflect_habits');
        $get_user_id = Input::get('uid');
        
        //IF HAVE Privilege 8+ then can sort by users as well
        if ($is_admin && null !== $get_user_id) {
            $lookup_user_id = $get_user_id;
        } else {
            $lookup_user_id = Auth::id();
        }
        $userSelect = User::where('privilege', '<', 8)->get();
        
        $user       = User::where('id', $lookup_user_id)->first();

        $date_later_than = Carbon::now()->subDays(8);   //DEFAULT value
        $date_less_than = Carbon::now();                //DEFAULT value
        

        
        if ( null !== Input::get('dtf')) {
            $date_later_than = Carbon::parse(Input::get('dtf'));
        }
        if ( null !== Input::get('dtt')) {
            $date_less_than = Carbon::parse(Input::get('dtt'));
        }

        //@@todo, viia User klassi? Viidud suur osa.
        $user = User::where('id', $lookup_user_id)->firstOrFail();
        $userFields = UserField::where('user_id', $lookup_user_id)
                                        ->where('active', true)
                                        ->get();
                                        
        // IF it is said in GET parameter what fields then use that
        if ( null !== Input::get('form_reflect_field')) {
            $userFieldsToForm = UserField::where('id', Input::get('form_reflect_field'))
                                            ->where('active', true)
                                            ->get();
        } else {
            $userFieldsToForm = $userFields;
        }
        $unique_habits = array(); //for filtering ID-> name, of all projects (attached to self user!) @@todo attach projects to usersby admin
                     
        foreach ($userFieldsToForm as $uf){
            //After page load habits are loaded for selection
            if ( null !== Input::get('form_reflect_field')) {
                $unique_habits[] = FHabit::where('userfield_id', Input::get('form_reflect_field'))->where('internal', false)->withCount('getLogs')->get();
            }

            // If Project is defined! @@todo multiple select siia..
            if ( null !== Input::get('form_reflect_habits')) {
                $fieldHabits[] = FHabit::where('id', Input::get('form_reflect_habits'))
                                    ->where('active', true)
                                    ->get();
            } else {
                $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                                    ->where('active', true)
                                    ->get();
            }
        }
        
        /*   Seda kasutab. ajapiiramised ?!?! */
        foreach ($fieldHabits as $fhh){
          foreach ($fhh as $fh){
            $dotiLogs[] = Dotilog::where('fieldhabit_id', $fh->id)
                                    ->where('date_log', '>=', $date_later_than)
                                    ->where('date_log', '<=', $date_less_than)
                                    ->orderBy('date_log', 'desc')
                                    ->get();
          }
        }

        $data['date_later_than'] = $date_later_than;
        $data['date_less_than'] = $date_less_than;
        $data['userFields'] = $userFields;
        $data['get_user_id'] = $get_user_id;
        $data['get_field_id'] = $get_field_id;
        $data['get_habit_id'] = $get_habit_id;
        
        $data['dotiLogs'] = $dotiLogs;
        $data['unique_habits'] = $unique_habits;
        $data['is_admin'] = $is_admin;
        $data['userSelect'] = $userSelect;

        return view('reflect', $data);
    }
    
    public function processFormFieldClicked($ufid){
        
        $userField = UserField::findOrFail($ufid); 
        $userField->toggleClicked();
        return $this->index();
    }
    public function processFormFieldActive($ufid){
        
        $userField = UserField::findOrFail($ufid); 
        $userField->toggleActive();
        return $this->index();
    }
    public function processFormFieldPublic($ufid){
        
        $userField = UserField::findOrFail($ufid); 
        $userField->togglePublic();
        return $this->index();
    }
    
    public function getDateForForm($value){
        return Carbon::parse($value)->format('m/d/Y');//->timezone('Europe/Tallinn');
    }

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
    
    private function getWelcomeMessage() {
        $w = array(
            'hi!',
            'hello there!',
            'glad you came',
            'glad you made it',
            'so good you came! :)',
            'nice to see you!',
            'I\'m so happy to see you here! Though I\'m just a piece of code :\')
            ');
        return $w[Rand(0,count($w) - 1)];
    }
}
