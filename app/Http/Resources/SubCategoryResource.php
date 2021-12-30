<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $category = $this->whenLoaded('category');
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'slug'=>$this->slug,
            'short_description' => $this->short_description,
            'image_url' => $this->image_url,
            'parent_category' => new CategoryResource($category)
        ];
    }
}
