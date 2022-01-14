<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function show(){
        $category = Category::with('subCategories.category')->get();
        return response(CategoryResource::collection($category));
    }

    // shows the categories but without the collection
    public function categories(){
        return response(Category::all());
    }

    public function create(Request $request){
        //
        Category::create([
            "title" => $request->categoryTitle,
            "short_description" => $request->categoryDescription,
            "slug" => Str::slug(Str::replace(' & ', "_", $request->categoryTitle), "_")
        ]);
        return response(["message" => "success"]);
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
        $category = Category::find($id);
        $category->title = $request->categoryTitle;
        $category->short_description = $request->categoryDescription;
        $category->slug = Str::slug(Str::replace(' & ', "_", $request->categoryTitle), "_");
        $category->save();

        return response(["message" => "success"]);
    }

    public function getCategory($id){
        return response(Category::find($id));
    }

    public function destroy($id){
        Category::find($id)->delete();
        return response(["message"=>"successful"]);
    }
}
