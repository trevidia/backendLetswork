<?php

namespace App\Http\Resources;

use App\Models\PackageSpecDetails;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->product_title,
            "package" => $this->package,
            "attribute" => $this->package != null ? $this->package->attributes : null
        ];
    }
}
