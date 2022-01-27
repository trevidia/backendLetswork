<?php

namespace App\Http\Controllers;

use App\Models\SellerInfo;
use App\Models\SellerLanguage;
use App\Models\User;
use App\Models\SellerSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountSetupController extends Controller
{
    public function createAccount(Request $request){
        SellerInfo::create([
            "location" => $request->country,
            "users_id" => $request->userId
        ]);
        return response(["message"=>"success"]);
    }

    public function category(Request $request){
        SellerInfo::where('users_id', $request->userId)->update(['sub_category_id' => $request->subcategoryId]);
        return response(["message"=> "success"]);
    }

    public function skill(Request $request){
        SellerSkill::create([
            "seller_skill_title" => $request->skillTitle,
            "level" => $request->skillLevel,
            "users_id"=> $request->userId
        ]);
        return response(["message" => "success"]);
    }

    public function languages(Request $request){

        foreach ($request->languages as $language){
            $sellerLanguages[] = [
                "language" => $language['language'],
                "level" => $language['proficiency'],
                "users_id" => $request->userId
            ];
        }
        SellerLanguage::insert($sellerLanguages);
        return response(["message"=> "success"]);
    }

    public function overview(Request $request){
        SellerInfo::where('users_id', $request->userId)->update(['seller_label' => $request->title, "description" => $request->overview, "seller_level" => "New Seller"]);
        return response(["message"=> "success"]);
    }

    public function profileImage(Request $request){
        $user = User::find($request->userId);
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $file = $request->file("image");
            $path = $file->store("images/profileImages");
            $user->image_url = env("APP_URL").":8000/".$path;
            $user->save();
            return response(["image_url" => $user->image_url]);
        }
    }
}
