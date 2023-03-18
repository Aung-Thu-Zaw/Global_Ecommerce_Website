<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "id"=>$this->id,
            "image"=>$this->image,
            "name"=>$this->name,
            "slug"=>$this->slug,
            "status"=>$this->status,
            "created_date"=>$this->created_at->format("Y/m/d"),
        ];
    }
}
