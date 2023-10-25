<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id"=> $this->id,
            "code"=> $this->code,
            "name"=> $this->name,
            "username"=> $this->username,
            "credit_limit"=> $this->credit_limit,
            "discount_limit"=> $this->discount_limit,
            "is_active"=> $this->is_active,
            "device_token"=> $this->device_token,
        ];
    }
}
