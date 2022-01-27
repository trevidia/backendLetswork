<?php

namespace App\Http\Resources;

use App\Models\GigStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class GigStatusDetailResource extends JsonResource
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
            'gig' => new GigResource($this->whenLoaded('gig')),
            'status' => $this->status
        ];
    }

}
