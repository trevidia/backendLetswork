<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\GigStatus;
use App\Models\GigStatusDetail;
use App\Models\GigTags;
use App\Models\PackageSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class GigsController extends Controller
{
    /**
     * Create a gig and give it tags.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

            $gigStatus = GigStatus::where('status', 'draft')->first()->id;
        $gig = Gig::firstOrCreate([
            'title' => $request['gigTitle'],
            'sub_category_id' => $request['subCategoryId'],
            'description' => $request['description'],
            'requirements'=> $request['requirements'],
            'slug' => Str::snake($request['gigTitle']),
            'user_id'=> $request['userId'],
            'gig_status_id' => $gigStatus
        ]);
        GigStatusDetail::firstOrCreate(
            ['gig_id' => $gig->id],
            ['gig_status_id' => $gigStatus
        ]);

        $tags = $request['tags'];
        foreach ($tags as $tag){
            GigTags::firstOrCreate(
                ["tag_title" => $tag,],
                ['gig_id' => $gig->id]
            );
        }
        return response(["message" => "success", "gig_id"=>$gig->id]);
    }

     /**
     * Logout the specified User Logged in.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct(Request $request){
        //
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // receives the gig id then matches the subcategory its under
    // then get the spec needed
    public function viewPackageSpec(Request $request, $id){

        return response();
    }

    public function proposalStatus(){
        //

    }

}
