<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request as SRequest;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
//use Illuminate\Session;

use App\User as User;
use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\Dotilog as Dotilog;
use App\FHabit as FHabit;
use App\BankDays as BankDays;
use App\BankValues as BankValues;

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
        $is_mode = ( User::where('id', Auth::id())->first()->privilege >= 5 );
        
        if (!$is_admin){
            return redirect('track');
        }
        
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
            'is_admin' => $is_admin,
            'is_mode'  => $is_mode,
            'userFields' => $fields,
            'openField'  => Input::get('field_id'),
            'specialWelcome' => $this->getWelcomeMessage(),
            'newField' => $newField,
            'newHabit' => $newHabit
            );
        
        // Ajax@home, here shouldn't do much
        if(Request::ajax()){
            echo "ajaxx!";
            $str = "123Ajax@HomeController";
            return $str;
        }
        
        return view('home', $data);
    }
    
    /* 
     * Something was $_POST'ed to /Home
     */
    public function postIndex(){
        //$this->displayGet();
        //$this->displayMeth();
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        
        if ($is_admin){
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
    public function reflect($csv = false){
        
        //echo $csv;
        
        // TESTING PARAMETER SHOW ONLY!! //
        //$this->displayGet();
        //$this->displayMeth();
        // TESTING END //
        
    $errmsg = null;
    
    
        $data = array();            //data array to be passed to View                              
        $fieldHabits = array();     //a link between a Habit and UserField
        $dotiLogs = array();        //a record of data
        $userSelect = array();      // array of user-id => name's
        
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        $is_mode = ( User::where('id', Auth::id())->first()->privilege >= 5 );
        
        // For admin
        $get_user_id = Input::get('uid');                       // User id
        $get_hid = Input::get('hid');                           // Habit id
        
        $user = User::where('id', Input::get('uid'))->first();
        
        $add_new_habit = false; // IF admin and ID os searched, we allow to make a button to add a habitlog for that person.

        //$date_later_than = ( null !== Input::get('dtf') ? Carbon::parse(Input::get('dtf')) : Carbon::now()->subDays(8));
        $date_later_than = ( null !== Input::get('dtf') ? Carbon::parse(Input::get('dtf')) : Carbon::parse(Carbon::now()->format('Y-m-') . '01'));
        
        $date_less_than = ( null !== Input::get('dtt') ? Carbon::parse(Input::get('dtt')) : Carbon::now());

        if ($is_admin) {
        $userSelect = User::where('privilege', '<', 11)->get();      //!Admin gets to selectfrom all usets
            if(null !== $get_user_id) {
                $add_new_habit = true;
                if (null !== $get_hid) { // IF admin wanted a specific project and user!
                    $ufs = FHabit::where('habit_id', $get_hid)->get()->pluck('userfield_id')->toArray();
                    $userFields = UserField::where('user_id', $get_user_id)->whereIn('id', $ufs)->get();
                } else {                // IF admin wanted a user!
                    $userFields = UserField::where('user_id', $get_user_id)->get();  //on both cases!
                }
            } else {                    // Admin, no user
                $userFields = $this->getRegularUserFields();
            }
        } else {                        // Not admin, by user
            $userFields = UserField::where('user_id', Auth::id())  //on both cases!
                    ->get();
        }

        $userFieldsToForm = $userFields;

        $unique_habits = array(); //for filtering ID-> name, of all projects (attached to user searched!)
        $all_habits = Habit::where('internal', 0)->get();
                        
        if ($add_new_habit) {
            foreach($user->getLinkedUserFields as $a){
                //print_r($a);
                $unique_habits = collect(FHabit::where('userfield_id', $a->id)->get());
            }
        }
        
        //print_r($unique_habits);
        
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
                    $fieldHabits[] = collect();
                    $errmsg = 'Palun vali *Kasutaja* või *Projekt*';
                    //$fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                    //        ->where('internal', 0)
                    //        ->get();
                }
            } else {
                $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                        ->where('internal', 0)
                        ->get();
                if (null !== $get_hid) { // IF admin wanted a speficif project and ALL users!
    //echo "e9";
                } else {
    //echo "e10"; 
                }
            }
        }
        
        /*   Seda kasutab. ajapiiramised ?!?! */
        foreach ($fieldHabits as $kk => $fhh){
          foreach ($fhh as $ll => $fh){
            $dotiLogs[] = Dotilog::where('fieldhabit_id', $fh->id)
                                    ->where('date_log', '>=', $date_later_than)
                                    ->where('date_log', '<=', $date_less_than)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
          }
        }

        $data['errmsg'] = $errmsg;
        $data['date_later_than'] = $date_later_than;
        $data['date_less_than'] = $date_less_than;
        $data['userFields'] = $userFields;
        
        $data['get_user_id'] = $get_user_id;
        $data['get_hid'] = $get_hid;
        $data['add_new_habit'] = $add_new_habit;
        $data['user'] = $user;
        
        $merged_collection = new Collection();
        foreach($dotiLogs as $key => $collection) {
            $merged_collection = $merged_collection->merge($collection)->sortBy('time_log');
        }
        
        $merged_collection = $merged_collection->sortByDesc('date_log');
        //print_r($merged_collection);
        
        $dotiLogs = $merged_collection;
        
        //print_r($dotiLogs);
        
        $data['newLog'] = new DotiLog;
        
        $data['dotiLogs'] = $dotiLogs;
        $data['unique_habits'] = $unique_habits;
        $data['all_habits'] = $all_habits;          //All Habit models with internal 0 values. For admin sort by habit name
        $data['is_admin'] = $is_admin;
        $data['is_mode'] = $is_mode;
        $data['userSelect'] = $userSelect;

        //print_r($dotiLogs);
        if ($csv == 1 && $is_admin){
            if (Input::get('submitbutton') == 'CSV'){
                //make csv with $dotiLogs
                $this->returnCsv($dotiLogs);
            }
            return view('reflect-csv', $data);
        }
        return view('reflect', $data);
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
     
    public function calendar(SRequest $request){    //gets chunked into months
    
    $errmsg = null;
    
    
    //print_r( $request->session()->get('success') );
    
    
$data = array();            //data array to be passed to View                              
        $fieldHabits = array();     //a link between a Habit and UserField
$dotiLogs = array();        //a record of data
$userSelect = array();      // array of user-id => name's

        
$is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
$is_mode = ( User::where('id', Auth::id())->first()->privilege >= 5 );
        
        // For admin
if ($is_admin) {
    $get_user_id = Input::get('uid');                       // User id
} else {
    $get_user_id = Auth::id();
}

        //$get_hid = Input::get('hid');                           // Habit id

        //$date_later_than = ( null !== Input::get('dtf') ? Carbon::parse(Input::get('dtf')) : Carbon::now()->subDays(8));
        $date_later_than = ( null !== Input::get('dtf') ? Carbon::parse(Input::get('dtf')) : Carbon::parse(Carbon::now()->format('Y-m-') . '01'));
        //$dl = $date_later_than;
        $date_less_than = $date_later_than->endOfMonth()->format('Y-m-d');
        $date_later_than->startOfMonth();
        //$date_less_than = ( null !== Input::get('dtt') ? Carbon::parse(Input::get('dtt')) : Carbon::now());
        $last_month_day = Carbon::parse($date_later_than)->subDay();
        
//echo $date_later_than .'#'. $date_less_than . "¤" . $last_month_day;

$bank_values = BankValues::where('date', '>=', $last_month_day->format('Y-m-d'))->where('date', '<=', $date_less_than)->get();
//$bank_values_personal = BankValues::where('date', '>=', $last_month_day->format('Y-m-d'))->where('date', '<=', $date_less_than)->where('user_id', $get_user_id)->get();
$bank_days = BankDays::where('date', '>=', $last_month_day->format('Y-m-d'))->where('date', '<=', $date_less_than)->get();
$bank_days_personal = BankDays::where('date', '>=', $last_month_day->format('Y-m-d'))->where('date', '<=', $date_less_than)->where('user_id', Auth::id())->get();

//print_r('<pre>');
//print_r($bank_values);
//print_r($bank_days_personal);
//print_r($bank_days);
//print_r('</pre>');

        $forward_job = null;
        if (config('doti-settings.job-forwarding') && Input::get('uid')) {
            $user = User::where('id', Input::get('uid'))->first();
            foreach($user->getLinkedUserFields as $a){
                //print_r($a);
                $fghabb = FHabit::where('userfield_id', $a->id)->get();
                foreach ($fghabb as $fghb) {
                    if ($fghb->habit_id == config('doti-settings.job-forwarding-habit-id')) {
                        //echo "::".$fghb->id;    //ufhabit_id
                        $forward_job = new Dotilog;
                        $forward_job->fieldhabit_id = $fghb->id;
                        //if
                        $newmonth = Carbon::parse( $date_later_than );
                        $forward_job->date_log =  $newmonth->addMonth()->format('Y-m-d');
                    }
                }
                //echo "::".$fghabb->id;
                //print_r($fghabb);
                
                //$unique_habits = collect(FHabit::where('userfield_id', $a->id)->get());
            }
        }

        if ($is_admin) {
        $userSelect = User::where('privilege', '<', 11)->get();      //!Admin gets to selectfrom all usets
            if(null !== $get_user_id) {
                // IF admin wanted a user!
                $userFields = UserField::where('user_id', $get_user_id)->get();  //on both cases!
            } else {                    // Admin, no user
                $errmsg = 'Palun vali kasutaja!';
                $request->session()->flash('message', 'Kalendri lehel saad üldiseid puhkepäevi lisada kõigile töötajatele korrada. Isiku valimisel saab seda teha individuaalselt.');
                $request->session()->flash('alert-class', 'alert-warning');
                $userFields = collect();
                //$userFields = $this->getRegularUserFields();
            }
        } else {                        // Not admin, by user
            $userFields = UserField::where('user_id', Auth::id())  //on both cases!
                    ->get();
        }

        $userFieldsToForm = $userFields;

        $unique_habits = array(); //for filtering ID-> name, of all projects (attached to self user!) @@todo attach projects to usersby admin
        $all_habits = Habit::where('internal', 0)->get();
                     
        foreach ($userFieldsToForm as $uf){
            
            if ($is_mode) {
                if(null !== $get_user_id) {

                    $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                                ->where('internal', 0)
                                ->get();

                } else {
    //echo "e7.5";
                    $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                            ->where('internal', 0)
                            ->get();
                }
            } else {
                $fieldHabits[] = FHabit::where('userfield_id', $uf->id)       // no separate [] add to array is needed, only messes up more arrays
                        ->where('internal', 0)
                        ->get();
            }
        }
        
        /*   Seda kasutab. ajapiiramised ?!?! */
        foreach ($fieldHabits as $kk => $fhh){
          foreach ($fhh as $ll => $fh){
            $dotiLogs[] = Dotilog::where('fieldhabit_id', $fh->id)
                                    ->where('date_log', '>=', $date_later_than)
                                    ->where('date_log', '<=', $date_less_than)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
          }
        }

        $data['date_later_than'] = $date_later_than;
        //$data['date_less_than'] = $date_less_than;
        //$data['userFields'] = $userFields;
        
        $data['get_user_id'] = $get_user_id;
        //$data['get_hid'] = $get_hid;
        
        $merged_collection = new Collection();
        foreach($dotiLogs as $key => $collection) {
            $merged_collection = $merged_collection->merge($collection)->sortBy('time_log');
        }
        
        $merged_collection = $merged_collection->sortByDesc('date_log');
        $dotiLogs = $merged_collection;
        
        //print_r($dotiLogs);
        
        //$data['errmsg'] = $errmsg;
        
        $data['dotiLogs'] = $dotiLogs;
        $data['forward_job'] = $forward_job;
        //$data['unique_habits'] = $unique_habits;
        $data['all_habits'] = $all_habits;          //All Habit models with internal 0 values. For admin sort by habit name
        $data['is_admin'] = $is_admin;
        $data['is_mode'] = $is_mode;
        $data['userSelect'] = $userSelect;
        
        $data['bankDays'] = $bank_days;
        $data['bankValues'] = $bank_values;

        return view('calendar', $data);
    }
    
    public function sync(){
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        if ($is_admin) {
            $users = $this->getRegularUsers();
        } else {
            $users = new Collection();
            $users = $users->merge(User::where('id', Auth::id())->get());
        }
            
        foreach ($users as $user) {
            //print_r($users);
            //dd($user);
            echo 'Sync for user: ' . $user->name;
            
            //Fieldid mis on vaid endal
            $uf = UserField::where('user_id', $user->id)->where('active', 1)->get();
            //Habitid' mis on vaid endal
            $self = FHabit::whereIn('userfield_id', $uf->pluck('id')->toArray())->where('active', 1)->get();        
            
            $all_fields = Field::all();
            $all_habits = Habit::all();
            
            foreach($all_fields->pluck('id')->toArray() as $fie) {
                //Is this habit also linked with self?
    //echo '!active: '.UserField::where('field_id', $fie)->where('active', 1)->first();
                if (null !== UserField::where('field_id', $fie)->where('active', 1)->first()) {
                    if (in_array($fie, $uf->pluck('field_id')->toArray()) ) {
    //echo ' !'.$fie.' is linked with self';
                    } else {
    //echo ' !'.$fie.' is to be added';
                        $this->addUserField($user->id, $fie);
                    }
                }
            } 
    
            foreach($all_habits->pluck('id')->toArray() as $hab) {
                //Is this habit also linked with self?
                if (null !== FHabit::where('habit_id', $hab)->where('active', 1)->first()) {
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
            }
        }

        return $this->index();
        
    }
    
    public function getBankHours($uid) {
        //start time 
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
    
    private function getRegularUsers() {
        return User::where('privilege', '<', '8')->get();
    }
    
    private function returnCsv($dotiLogs){
        $filename = "tweets.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('tweet text', 'screen name', 'name', 'created at'));
    
        //foreach($table as $row) {
            fputcsv($handle, array('123', '123') );
        //}
    
        fclose($handle);
    
        $headers = array(
            'Content-Type' => 'text/csv',
        );
    
        return Response::download($filename, 'tweets.csv', $headers);
        //return Response->download($filename, 'tweets.csv', $headers);
    }
}
