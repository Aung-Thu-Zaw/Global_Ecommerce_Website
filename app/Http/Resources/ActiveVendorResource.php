<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveVendorResource extends JsonResource
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
            "name"=>$this->name,
            "avatar"=>$this->avatar,
            "shop_name"=>$this->shop_name,
            "company_name"=>$this->company_name,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "address"=>$this->address,
            "about"=>$this->about,
            "role"=>$this->role,
            "status"=>$this->status,
            "created_date"=>$this->created_at->format("Y/m/d"),
        ];
    }
}
