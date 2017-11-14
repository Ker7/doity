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

use App\Http\Traits\BinderTrait;

use Carbon\Carbon;

use Illuminate\Support\Facades\Route as Route;

class HomeController extends Controller
{
    use BinderTrait;
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
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        
        $newField = new Field;
        $newHabit = new Habit;
        
        if ($is_admin) {
            $fields = UserField::where('user_id', Auth::id())
                                        ->get();
        } else {
            $fields = UserField::where('user_id', Auth::id())
                                        ->where('active', true)         //Retrieve only active fields
                                        ->get();
        }
        
        
        
        $data = array(
            'userFields' => $fields,
            //'userFieldsUnactive' => UserField::where('user_id', Auth::id())
            //                            ->where('active', false)         //Retrieve nonactive fields
            //                            ->get(),
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
        
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        $is_mode = ( User::where('id', Auth::id())->first()->privilege >= 5 );

        $get_field_id = Input::get('form_reflect_field');       // !!TOREMOVE!! If set then use it to display default option in form @@toremoveee bad idea
        $get_habit_id = Input::get('form_reflect_habits');      // UserFieldHabit id @@Toremove? Or let for users
        
        // For admin
        $get_user_id = Input::get('uid');                       // User id
        $get_hid = Input::get('hid');                           // Habit id

        $date_later_than = ( null !== Input::get('dtf') ? Carbon::parse(Input::get('dtf')) : Carbon::now()->subDays(8));
        $date_less_than = ( null !== Input::get('dtt') ? Carbon::parse(Input::get('dtt')) : Carbon::now());

        //$lookup_user_id = -1;
//IF HAVE Privilege 8+ then can sort by users as well
//echo "e1";
        if ($is_admin) {
//echo "e2";
        $userSelect = User::where('privilege', '<', 8)->get();      //!Admin gets to selectfrom all usets
            if(null !== $get_user_id) {
//echo "e3";
                if (null !== $get_hid) { // IF admin wanted a speficif project and ALL users!
//echo "e4";
                    // Get All UFHabit (hid) -> field_id
                    // Get All UField (uid, field_id)
                    //$ufhs = FHabit::where('habit_id', $get_hid)->get()->toArray()->pluck('userfield_id');
                    $ufs = FHabit::where('habit_id', $get_hid)->get()->pluck('userfield_id')->toArray();
                    $userFields = UserField::where('user_id', $get_user_id)->whereIn('id', $ufs)->get();  //TEMP
//print_r($ufs);
//print_r($userFields);
                    //$userFields = UserField::where('user_id', $get_user_id)->get();  //TEMP
                } else {
//echo "e5";                    
                    $userFields = UserField::where('user_id', $get_user_id)->get();  //on both cases!
                }
//echo "e6";
            //$lookup_user_id = -1;       // all users
            } elseif (null !== $get_habit_id) {
//echo "d7";
                $userFields = $this->getRegularUserFields();
            } else {
//Admin, no user no habit, blank page? Error?
//echo "d7.5";
                $userFields = $this->getRegularUserFields();
            //$lookup_user_id = Auth::id();
            }
        } else {
//echo "e8";
            $userFields = UserField::where('user_id', Auth::id())  //on both cases!
                    ->get();
            if (null !== $get_habit_id) { // IF admin wanted a speficif project and ALL users!
//echo "e9";
            } else {
//echo "e10"; 
            }
        }




////IF HAVE Privilege 8+ then can sort by users as well
////echo "1
//        if ($is_admin) {
////echo "2";
//            if( null !== $get_user_id) {
////echo "3";
//                $lookup_user_id = $get_user_id;     // IF admin wanted a specific USER
//            } elseif ( null !== $get_habit_id) { // IF admin wanted a speficif project and ALL users!
////echo "4";
//                $lookup_user_id = -1;
//            } else {
////echo "6";
//                $lookup_user_id = -1;       // all users
//            }
//        } else {
////echo "7";
//            $lookup_user_id = Auth::id();
//        }
//        $userSelect = User::where('privilege', '<', 8)->get();
//        
////echo "8";

        //$user       = User::where('id', $lookup_user_id)->first();
//        if ($is_admin){
//            if ($lookup_user_id == -1) {
//                $userFields = $this->getRegularUserFields();
////foreach($userFields as $uf) {
////    echo ';'.$uf->id.';';
////}
//            } else {
//                $userFields = UserField::where('user_id', $lookup_user_id)
//                                        ->get();
//                }
//        } else {
//            $userFields = UserField::where('user_id', $lookup_user_id)
//                                        ->where('active', true)
//                                        ->get();
//        }
        
// ############ LOOKUP USER ID no more

         //IF it is said in GET parameter what fields then use that
         // TOREMOVE START
        //if ( null !== Input::get('form_reflect_field')) {
        //    if ($is_admin){
        //        $userFieldsToForm = UserField::where('id', Input::get('form_reflect_field'))
        //                                    ->get();
        //    } else {
        //        $userFieldsToForm = UserField::where('id', Input::get('form_reflect_field'))
        //                                    ->where('active', true)
        //                                    ->get();
        //    }
        //} else {
            $userFieldsToForm = $userFields;
            
            //print_r( $userFields->pluck('id')->toArray() );
        //}
        // TOREMOVE END
        
        
        $unique_habits = array(); //for filtering ID-> name, of all projects (attached to self user!) @@todo attach projects to usersby admin
        $all_habits = Habit::where('internal', 0)->get();
                     
        foreach ($userFieldsToForm as $uf){
            
            if ($is_admin) {
                if(null !== $get_user_id) {
                    if (null !== $get_hid) { // IF admin wanted a speficif project and ALL users!
    //echo "e4";
                        $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                                    ->where('habit_id', $get_hid)
                                    ->where('internal', 0)
                                    ->get();
                    } else {
    //echo "e5";
                        $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                                    ->where('internal', 0)
                                    ->get();
                    }
                } elseif (null !== $get_hid) {
    //echo "e7";
                    $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                            ->where('habit_id', $get_hid)
                            ->where('internal', 0)
                            ->get();
                } else {
    //echo "e7.5";
                    $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                            ->where('internal', 0)
                            ->get();
                }
            } else {
                //echo $uf->id.',';
                $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                        ->where('internal', 0)
                        ->get();
                if (null !== $get_habit_id) { // IF admin wanted a speficif project and ALL users!
    //echo "e9";
                } else {
    //echo "e10"; 
                }
            }
            
            //After page load habits are loaded for selection
            
            //if ( null !== Input::get('form_reflect_field')) {
            //    $unique_habits[] = FHabit::where('userfield_id', Input::get('form_reflect_field'))
            //                        ->where('internal', false)
            //                        ->withCount('getLogs')->get();
            //}
            
            // TOREM start
            //if ($is_admin) {
            //    if (null !== Input::get('form_reflect_habits')) {
            //        $fieldHabits[0] = FHabit::where('id', Input::get('form_reflect_habits'))
            //                        ->where('internal', 0)
            //                        ->get();
            //    } else {
            //        $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
            //                        ->where('internal', 0)
            //                        ->get();
            //    }
            //} else {
            //    if (null !== Input::get('form_reflect_habits')) {
            //        $fieldHabits[] = FHabit::where('id', Input::get('form_reflect_habits'))
            //                        ->where('active', true)
            //                        ->where('internal', 0)
            //                        ->get();
            //    } else {
            //        $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
            //                        ->where('active', true)
            //                        ->where('internal', 0)
            //                        ->get();
            //    }
            //}
            // TOREM end
            
//if ($is_admin){
//} else {
//}

        }
        
        /*   Seda kasutab. ajapiiramised ?!?! */
        foreach ($fieldHabits as $kk => $fhh){
//echo ' ¤kk-'.$kk;            
          foreach ($fhh as $ll => $fh){
//echo ' #ll-'.$ll;         
            $dotiLogs[] = Dotilog::where('fieldhabit_id', $fh->id)
                                    ->where('date_log', '>=', $date_later_than)
                                    ->where('date_log', '<=', $date_less_than)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
          }
        }

        $data['date_later_than'] = $date_later_than;
        $data['date_less_than'] = $date_less_than;
        $data['userFields'] = $userFields;
        $data['get_user_id'] = $get_user_id;
        $data['get_field_id'] = $get_field_id;
        $data['get_habit_id'] = $get_habit_id;
        $data['get_hid'] = $get_hid;
        
        $data['dotiLogs'] = $dotiLogs;
        $data['unique_habits'] = $unique_habits;
        $data['all_habits'] = $all_habits;          //All Habit models with internal 0 values. For admin sort by habit name
        $data['is_admin'] = $is_admin;
        $data['userSelect'] = $userSelect;

        //print_r($dotiLogs);
        
        return view('reflect', $data);
    }
    
    public function sync(){
        $user = User::where('id', Request::input('uid'))->first();
        
        echo 'Sync for user: ' . $user->name;
        
        //Fieldid mis on vaid endal
        $uf = UserField::where('user_id', $user->id)->where('active', 1)->get();
        //Habitid' mis on vaid endal
        $self = FHabit::whereIn('userfield_id', $uf->pluck('id')->toArray())->where('active', 1)->get();        
        
        $all_fields = Field::all();
        $all_habits = Habit::all();
        
        foreach($all_fields->pluck('id')->toArray() as $fie) {
            //Is this habit also linked with self?
            if (in_array($fie, $uf->pluck('field_id')->toArray()) ) {
//echo $fie.' is linked with self';
            } else {
//echo $fie.' is to be added';
                $this->addUserField($user->id, $fie);
            }
        } 

        foreach($all_habits->pluck('id')->toArray() as $hab) {
            //Is this habit also linked with self?
            if (in_array($hab, $self->pluck('habit_id')->toArray()) ) {
//echo $hab.' is linked with self';
            } else {

                $to_field_habit = FHabit::where('habit_id', $hab)->pluck('userfield_id')->first();
                $to_field = UserField::where('id', $to_field_habit)->pluck('field_id')->first();

                if (null !== $to_field_habit){
                    $this->addFieldHabit(
                                     UserField::where('user_id', $user->id)->where('field_id', $to_field)->pluck('id')->first(),
                                     $hab,
                                     'h',
                                     '_integration');
                } else {
                    // @@todo add notice of unadded field. possibli a stray habit somehow
                    echo 'Habit #'.$hab.' could not be added!';
                }

            }
        } 

        return $this->index();
        
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
    
    private function getRegularUserFields() {
        $users_na = array();
        foreach (User::where('privilege', '<', '8')->get() as $uis){
            $users_na[] = $uis->id;
//echo "*".$uis->id."*";
        }
        return UserField::whereIn('user_id', $users_na)->get();
    }
}
