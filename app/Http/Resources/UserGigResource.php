<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "image" => $this->gallery->image1_location,
            "status" => $this->statusDetails->status,
            "seller_level" => $this->user->info->seller_level,
            "username" => $this->user->username,
            "profile_img" => $this->user->image_url,
            "products" => ProductResource::collection($this->product)
        ];
    }
}
