<?php

namespace App\Http\Resources;

use App\Models\Roles;
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
            'id' => $this->id,
            'roles' => new RolesResource($this->roles),
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar
        ];
    }
}
