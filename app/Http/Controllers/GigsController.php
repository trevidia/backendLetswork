<?php

namespace App\Http\Controllers;

use App\Http\Resources\GigResource;
use App\Http\Resources\GigStatusResource;
use App\Http\Resources\ProductResource;
use App\Models\Gig;
use App\Models\GigExtra;
use App\Models\GigFAQ;
use App\Models\GigGallery;
use App\Models\User;
use App\Models\GigStatus;
use App\Models\GigStatusDetail;
use App\Models\GigTags;
use App\Models\Package;
use App\Models\PackageSpec;
use App\Models\PackageSpecDetails;
use App\Models\Product;
use Error;
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

        $gig = Gig::firstOrCreate([
            'title' => $request['gigTitle'],
            'sub_category_id' => $request['subCategoryId'],
            'description' => $request['description'],
            'requirements'=> $request['requirements'],
            'slug' => Str::snake($request['gigTitle']),
            'user_id'=> $request['userId'],
        ]);
        GigStatusDetail::firstOrCreate(
            ['gig_id' => $gig->id],
            ['status' => 'draft'
        ]);

        $tags = $request['tags'];
        foreach ($tags as $tag){
            GigTags::create(
                ["tag_title" => $tag, 'gig_id' => $gig->id]
            );
        }
        return response(["message" => "success", "gig_id"=>$gig->id]);
    }

     /**
     *
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

    public function proposalStatus(Request $request, $id){
        //
        $gig = User::find($id)->gigs()->with(['views', 'orders', 'product', 'statusDetails',])->get();
        return response(GigResource::collection($gig));

    }

    public function view($gigId){

        try{
            $gig = Gig::find($gigId);
            $basicProduct = $gig->product->where("product_title", "basic")->first();
            $standardProduct = $gig->product->where("product_title", "standard")->first();
            $premiumProduct = $gig->product->where("product_title", "premium")->first();
            $gigextras = $gig->gigExtras;
            $response = [
                "id" => $gig->id,
                "title" => $gig->title,
                "description" => $gig->description,
                "requirements" => $gig->requirements,
                "gigTags" => $gig->tags,
                "gigFaqs" => $gig->gigFaqs,
                "packages" => [
                    "basic" =>  $basicProduct != null ? new ProductResource($basicProduct) : null,
                    "standard" =>  $standardProduct != null ? new ProductResource($standardProduct) : null,
                    "premium" =>  $premiumProduct != null ? new ProductResource($premiumProduct) : null,
                ],
                "gigExtras" => $gigextras,
                "gallery" => $gig->gallery,
                "subCategory"=>$gig->subCategory,
                "status" => $gig->statusDetails->status,
                "username" => $gig->user->username,
                "attributes" => $gig->subCategory->specs
        ];
        return response($response);
        }catch(Error $e){
            return response(["message" => "Not Found"], 404);
        }
    }

    public function updateGig(Request $request, $gigId){
        $gig = Gig::find($gigId);
        $gig->title = $request['gigTitle'] ?? $gig->title;
        $gig->requirements = $request['requirements'] ?? $gig->requirements;
        $gig->description = $request['description'] ?? $gig->description;
        $gig->slug = $request['gigTitle'] != null ? Str::snake($request['gigTitle']) : $gig->slug ;
        $tags = $request['tags'] ?? $gig->tags;
        $faqs = $request['faqs'] ?? $gig->gigFaqs;

        // if the count of the gig tags aren't zero then
        // create tags after deleting them

        if (count($tags) != 0 && $request['tags'] != null){
            GigTags::where('gig_id', $gigId)->delete();
            foreach ($tags as $tag){
                GigTags::firstOrCreate(
                    ["tag_title" => $tag, 'gig_id' => $gigId]
                );
            }
        }

        // if the count of the faqs aren't zero then create faqs
        // after deleting all the faqs

        if (count($faqs) != 0 && $request['faqs'] != null){
            GigFAQ::where('gig_id', $gigId)->delete();
            foreach ($faqs as $faq){
                $faqArray[] = [
                    'question' => $faq['question'],
                    'answer'=> $faq['answer'],
                    'gig_id'=> $gig->id
                ];
            }
            GigFAQ::insert($faqArray);
        }

        // if they are in the package form it should take the values
        // and store them

        if ($request->basic != null && $request->standard != null && $request->premium != null){
            $basicProduct = Product::firstOrCreate([
                "gig_id" => $gig->id, "product_title" => "basic"
            ]);
            $premiumProduct = Product::firstOrCreate([
                "gig_id" => $gig->id, "product_title" => "premium"
            ]);
            $standardProduct = Product::firstOrCreate([
                "gig_id" => $gig->id, "product_title" => "standard"
            ]);

            Package::upsert([
            [
                "package_description" => $request->basic["description"],
                "days_to_completion" => $request->basic["delivery"],
                "revision_count" => $request->basic["revision"],
                "price" => $request->basic["price"],
                "product_id" => $basicProduct->id
            ],
            [
                "package_description" => $request->standard["description"],
                "days_to_completion" => $request->standard["delivery"],
                "revision_count" => $request->standard["revision"],
                "price" => $request->standard["price"],
                "product_id" => $standardProduct->id
            ],
            [
                "package_description" => $request->premium["description"],
                "days_to_completion" => $request->premium["delivery"],
                "revision_count" => $request->premium["revision"],
                "price" => $request->premium["price"],
                "product_id" => $premiumProduct->id
            ],
            ],["product_id"], ["package_description", "days_to_completion", "revision_count", "price"]);

            $basicPackageId = $basicProduct->package->id;
            $standardPackageId = $standardProduct->package->id;
            $premiumPackageId = $premiumProduct->package->id;

            foreach ($request->basic["attributes"] as $attribute){
                $basicAttributes[] = [
                    "spec" => $attribute["title"],
                    "package_spec_detail_value" => $attribute['value'],
                    'package_spec_id' => $attribute["attributeId"],
                    'package_id' => $basicPackageId
                ];
            }
            foreach ($request->standard["attributes"] as $attribute){
                $standardAttributes[] = [
                    "spec" => $attribute["title"],
                    "package_spec_detail_value" => $attribute['value'],
                    'package_spec_id' => $attribute["attributeId"],
                    'package_id' => $standardPackageId
                ];
            }
            foreach ($request->premium["attributes"] as $attribute){
                $premiumAttributes[] = [
                    "spec" => $attribute["title"],
                    "package_spec_detail_value" => $attribute['value'],
                    'package_spec_id' => $attribute["attributeId"],
                    'package_id' => $premiumPackageId
                ];
            }

            $mainAttributes = array_merge($basicAttributes, $standardAttributes, $premiumAttributes);
            // dd($basicAttributes);

            PackageSpecDetails::upsert($mainAttributes, ["package_spec_id", "package_id"], ["package_spec_detail_value"]);

            // $attributes = PackageSpec::
        } else if($request->basic != null) {
            $basicProduct = Product::firstOrCreate([
                "gig_id" => $gig->id, "product_title" => "basic"
            ]);


            Product::whereIn("product_title", ["premium", "standard"])->delete();
            $basic = $request['basic'];
            Package::upsert([
                [
                    "package_description" => $basic["description"],
                    "days_to_completion" => $basic["delivery"],
                    "revision_count" => $basic["revision"],
                    "price" => $basic["price"],
                    "product_id" => $basicProduct->id
                ],], ["product_id"], ["package_description", "days_to_completion", "revision_count", "price"]);

            $basicPackageId = $basicProduct->package->id;

            foreach ($request->basic["attributes"] as $attribute){
                    $basicAttributes[] = [
                        "spec" => $attribute["title"],
                        "package_spec_detail_value" => $attribute['value'],
                        'package_spec_id' => $attribute["attributeId"],
                        'package_id' => $basicPackageId
                    ];
                }

                PackageSpecDetails::upsert($basicAttributes, ["package_spec_id", "package_id"], ["package_spec_detail_value"]);
        }

        $countextra = $request->extras ?? [];
        if(count($countextra) != 0){
            $gigextras = $gig->gigExtras;
            if (count($gigextras) != 0 ){
                foreach ($gigextras as $extraProduct){
                    $productIds[] = [
                        $extraProduct->product_id
                    ];
                }
                Product::destroy($productIds);
            }
            foreach ($request->extras as $extra){
                $product = Product::firstOrCreate([
                    "gig_id" => $gig->id, "product_title" => $extra['title']]);
                $extras[] = [
                    "gig_extra_title" => $extra["title"],
                    'price' => $extra['price'],
                    'additional_days' => $extra['additionalDays'],
                    'custom_extra' => $extra['custom'],
                    'product_id' => $product->id,
                    'gig_id' => $gig->id
                ];
            }
            GigExtra::insert($extras);
        }

        $gig->save();
        return response(["message" => $gig->gigExtras]);
    }

    public function deactivate(Request $request, $gigId ){
        $gig = Gig::find($gigId);
        $statusDetails = $gig->statusDetails;
        $statusDetails->status = 'paused';
        $statusDetails->save();
        return response(["message" => "success"]);
    }

    public function saveImages(Request $request, $gigId){
        $gig = Gig::find($gigId);

        $storageFolder = 'images/gigImages';
        if ( $request->hasFile('gig_image1') && $request->file('gig_image1')->isValid()){
            $fileName = $request->file('gig_image1')->getClientOriginalName();
            $path = $request->file('gig_image1')->storeAs($storageFolder, $fileName);
            if ($gig->gallery == null){
                GigGallery::create([
                    'image1_location' => $path,
                    "gig_id" => $gig->id
                ]);
            } else{
                $gig->gallery->image1_location = $path;
            }
            $gig->gallery->save();
            return (["path" => $path]);
        }
        if ($request->hasFile('gig_image2') && $request->file('gig_image2')->isValid()){
            $fileName = $request->file('gig_image2')->getClientOriginalName();
            $path = $request->file('gig_image2')->storeAs($storageFolder, $fileName);
            $gig->gallery->image2_location = $path;
            $gig->gallery->save();
            return response(["path"=> $path]);
        }
        if ($request->hasFile('gig_image3') && $request->file('gig_image3')->isValid()){
            $fileName = $request->file('gig_image3')->getClientOriginalName();
            $path = $request->file('gig_image3')->storeAs($storageFolder, $fileName);
            $gig->gallery->image3_location = $path;
            $gig->gallery->save();
            return response(["path"=> $path]);
        }

        if ($request->hasFile('video') && $request->file('video')->isValid()){
            $fileName = $request->file('video')->getClientOriginalName();
            $path = $request->file('video')->storeAs("videos/" . $gigId, $fileName);
            $gig->gallery->video_location = $path;
            $gig->gallery->save();
            return response(["path"=> $path]);
        }
        // $fileName = $request->file('gig_image1')->getClientOriginalName();
        // $path = $request->file('gig_image1')->store('gigImages');
        return response(["message" => "success"]);
    }

    public function activate(Request $request, $gigId ){
        $gig = Gig::find($gigId);
        $statusDetails = $gig->statusDetails;
        $statusDetails->status = 'active';
        $statusDetails->save();
        return response(["message" => "success"]);
    }

    public function delete(Request $request, $gigId ){
        Gig::find($gigId)->delete();
        return response(["message" => "success"]);
    }

}
