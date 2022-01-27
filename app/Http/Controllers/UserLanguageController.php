<?php

namespace App\Http\Controllers;

use App\Models\UserLanguage;
use Illuminate\Http\Request;

class UserLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(UserLanguage::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserLanguage::firstOrCreate([
            "language"=> $request->sellerLanguage
        ]);
        return response(["message"=>"success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserLanguage  $userLanguage
     * @return \Illuminate\Http\Response
     */
    public function show($userLanguage)
    {
        //
        return response(UserLanguage::find($userLanguage));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserLanguage  $userLanguage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLanguage $userLanguage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userLanguage = UserLanguage::find($id);
        $userLanguage->language = $request->sellerLanguage;
        $userLanguage->save();
        return response(["message" => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserLanguage  $userLanguage
     * @return \Illuminate\Http\Response
     */
    public function destroy($userLanguage)
    {
        //
        UserLanguage::find($userLanguage)->delete();
        return response(["message"=>"success"]);
    }
}
