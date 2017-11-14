<?php

namespace App\Http\Controllers;

use App\User;
use App\FHabit;
use App\Habit;
use App\UserField;

use App\Http\Traits\BinderTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

class FHabitController extends Controller
{
    use BinderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "FHabit@index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "FHabit@create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return ;
        $a = "";
        
        $post_type = $request->input('form_name');
        
        $user_field = $request->input('field_id');
        $habit_name = $request->input('name');
        
        $newHabit = new Habit;      // new habit!
        $newHabit->name = $habit_name;
        $newHabit->author_user = Auth::user()->id;
        $newHabit->internal = 0;
        $newHabit->public = 0;
        $newHabit->save();

        //print_r(UserField::where('id', $user_field)->get()[0]->field_id);
        //$uf_id = UserField::where('id', $user_field)->get()[0]->field_id;
        
            // Nüüd peaks ilmselt siin mingi test olema kas kõik oli edukas ja siis luuakse uus UserField selle saadud ID alusel
        if (config('doti-settings.admin-adds-global-fields-to-all-users')) {
            foreach(UserField::where('field_id', UserField::where('id', $user_field)->get()[0]->field_id)->get() as $userfields ){
                //$newFHabit = new FHabit;        // new Field Habit
                //$newFHabit->userfield_id = $userfields->id;
                //$newFHabit->habit_id = $newHabit->id;
                //$newFHabit->internal = 0;
                //$newFHabit->unit_id = 1;        // 1 - placeholder for decimal! 2-time, 3-percentage
                //$newFHabit->unit_name = $request->input('unit_name');
                //$newFHabit->active = 1;
                //$newFHabit->public = 0;
                //$newFHabit->comment = $request->input('comment');
                //$newFHabit->save();
                $this->addFieldHabit($userfields->id, $newHabit->id, $request->input('unit_name'), $request->input('comment'));
            }
        } else {
            //$newFHabit = new FHabit;        // new Field Habit
            //$newFHabit->userfield_id = $user_field;
            //$newFHabit->habit_id = $newHabit->id;
            //$newFHabit->internal = 0;
            //$newFHabit->unit_id = 1;        // 1 - placeholder for decimal! 2-time, 3-percentage
            //$newFHabit->unit_name = $request->input('unit_name');
            //$newFHabit->active = 1;
            //$newFHabit->public = 0;
            //$newFHabit->comment = $request->input('comment');
            //$newFHabit->save();
            $this->addFieldHabit($user_field, $newHabit->id, $request->input('unit_name'), $request->input('comment'));
        }
        
        return redirect()->action('HomeController@index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function show(FHabit $fHabit)
    {
        return "FHabit@show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        
        $habit_id = FHabit::where('id', $request->input('fieldhabit_id'))->first()->habit_id;
        //echo $habit_id;
        
        $fieldHab = FHabit::where('id', $request->input('fieldhabit_id'))->first();
        $fieldHabs = array();
        
        if ($is_admin){
            $fieldHabs = FHabit::where('habit_id', $habit_id)->get();
        } else {
            $fieldHabs[] = $fieldHab;
        }
        
        //print_r ($fieldHabs);
        
        foreach($fieldHabs as $fieldHabit) {
            switch($request->input('form_name')) {
                case('fieldhabit_active'): $fieldHabit->toggleActive(); break;
                case('fieldhabit_public'): $fieldHabit->togglePublic(); break;
                default: break;
            }
        }
        
        // @todo errmsg if
        return redirect()->action('HomeController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FHabit $fHabit)
    {
        return "FHabit@update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function destroy(FHabit $fHabit)
    {
        return "FHabit@destory";
    }
}
