<?php

namespace App\Http\Resources;

use App\Models\GigGallery;
use Illuminate\Http\Resources\Json\JsonResource;

class GigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = $this->product->where('product_title', "basic")->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'gig_description' => $this->description,
            'requrements' => $this->requirements,
            'slug' => $this->slug,
            'price' => $product != null ? $product->package->price : null,
            'views' => ViewResource::collection($this->whenLoaded('views')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'gig_extras' => GigExtraResource::collection($this->whenLoaded('gigExtras')),
            'gig_faqs' => GigFaqResource::collection($this->whenLoaded('gigFaqs')),
            'gig_gallery'=> GigGalleryResource::collection($this->whenLoaded('gallery')),
            'gig_status' => [
                'status' => $this->statusDetails->status,
                'message' => $this->statusDetails->message
            ],
            'user' => $this->user,
            // 'package_spec'=> $this->subCategory->specs
        ];
    }
}
