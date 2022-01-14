<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (DB::table('users')->where('email', $request["email"])->doesntExist()) {
            // ...
            $user = User::create([
                "given_name" => $request["givenName"],
                "family_name" => $request["familyName"],
                "email" => $request["email"],
                "image_url"=> $request["imageUrl"],
                "google_id"=> $request["googleId"],
                "linked_in_id"=> $request['linkedInId'],
            ]);
        } else {
            $user = User::where('email', $request["email"])->first();
        }

        Auth::login($user);
        $loggedUser = Auth::user();
        $token = $loggedUser->createToken("token");
        $cookie = cookie('jwt', $token->plainTextToken, 60 * 24);
        return response(["userId"=> $loggedUser->id, "tokenId" => $token->accessToken->id, "message" => "success"])->withCookie($cookie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser($username)
    {
        //
        // return response(gettype($username));
        $user = User::where('username', $username)->get()->first();

        return $user;
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $user->username = $request['username'];
        $user->save();
        return response(["message" => "success"]);
    }

    /**
     * Logout the specified User Logged in.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $user = User::find($request["id"]);
        $user->tokens()->where('id', $request["tokenId"])->delete();
        $cookie = Cookie::forget('jwt');

        return response(["message" =>  $user])->withCookie($cookie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
