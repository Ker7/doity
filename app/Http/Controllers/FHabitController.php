<?php

namespace App\Http\Controllers;

use App\FHabit;
use Illuminate\Http\Request;

class FHabitController extends Controller
{
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
        return "FHabit@store";
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
    public function edit(FHabit $fHabit)
    {
        return "FHabit@edit";
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
