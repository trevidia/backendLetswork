<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    //
    public function create(Request $request){
        if ($request->id != null){
            $subcategory = SubCategory::find($request->id);
            Storage::delete($subcategory->image_url);
            $subcategory->delete();
            return response(SubCategory::with('category')->paginate(10));
        }
       $path = $request->file('file')->store('subcategory');
       try{
        SubCategory::create([
            "title" => $request->subCategoryTitle,
            "description" => $request->subCategoryDescription,
            "image_url" => $path,
            "slug" =>  Str::slug(Str::replace(' & ', "_", $request->subCategoryTitle), "_"),
            'category_id' => $request->categoryId
        ]);
       } catch (Exception $e){
        Storage::delete($path);
        return response(["message" => $e]);
       }
        return response(["message" => "success"]);
    }

    public function viewPaginated(){
        // $response = SubCategory::paginate()
        $subcategory = SubCategory::with('category');
        return response($subcategory->paginate(10));
    }

    public function getSubCat($id){

        // $subcategory = SubCategory::with('category');
        return response(SubCategory::find($id));
    }

    public function updateSubcat(Request $request, $id){
        $subcategory = SubCategory::find($id);
        Storage::delete($subcategory->image_url);
        $path = $request->file('file')->store('subcategory');
        $subcategory->image_url = $path;
        $subcategory->title = $request->subCategoryTitle;
        $subcategory->description = $request->subCategoryDescription;
        $subcategory->slug = Str::slug(Str::replace(' & ', "_", $request->subCategoryTitle), "_");
        $subcategory->category_id = $request->categoryId;
        $subcategory->save();
        // $subcategory = SubCategory::with('category');
        return response(["message"=>"success"]);
    }
}
