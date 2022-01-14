<?php

namespace App\Http\Controllers;

use App\Models\PackageSpec;
use Illuminate\Http\Request;

class PackageSpecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response(PackageSpec::with('subCategory.category')->paginate(10));
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
        if ($request->package_id != null){
            $packageSpec = PackageSpec::find($request->package_id);
            $packageSpec->delete();
            return response(PackageSpec::with('subCategory.category')->paginate(10));
        }
        //
        PackageSpec::create([
            "specification" => $request->attributeName,
            "type" => $request->attributeType,
            "extra_spec_title" => $request->extraTitle,
            "drop_down_range" => $request->attributeRange,
            "sub_category_id" => $request->subcategoryId
        ]);
        return response(["message" => "success"]);
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
        return response(PackageSpec::with('subCategory.category')->find($id));
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
        $packageSpec = PackageSpec::find($id);
        $packageSpec->specification = $request->attributeName;
        $packageSpec->type = $request->attributeType;
        $packageSpec->extra_spec_title = $request->extraTitle;
        $packageSpec->drop_down_range = $request->attributeRange;
        $packageSpec->sub_category_id = $request->subcategoryId;
        $packageSpec->save();
        return response(["message"=> "success"]);
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
