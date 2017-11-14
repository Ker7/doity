<?php

namespace App\Http\Controllers;

use App\User;
use App\Field;
use App\UserField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Traits\BinderTrait;

use Illuminate\Support\Facades\Redirect;

class FieldController extends Controller
{
    use BinderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "FCont@index!";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "FCont@create!";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $field = new Field;
        $field->name = $request->name;
        $field->color = $request->colorForField;
        $field->author_user = Auth::user()->id;
        $field->save();
        
        // Nüüd peaks ilmselt siin mingi test olema kas kõik oli edukas ja siis luuakse uus UserField selle saadud ID alusel
        if (config('doti-settings.admin-adds-global-fields-to-all-users')) {
            foreach(User::all() as $user ){
                $this->addUserField($user->id, $field->id);
            }
        } else {
            $this->addUserField(Auth::user()->id, $field->id);
        }
        
        return redirect()->action('HomeController@index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function testStore()
    {
        //$field = new Field;
        //$field->name = 'test123';
        //$field->color = '#123acb';
        //$field->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        return "FCont@show!";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        return "FCont@edit!";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        return "FCont@update!";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        return "FCont@destroy!";
    }
}
