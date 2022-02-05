<?php

namespace App\Http\Resources;

use App\Models\Institution;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'institution' => new InstitutionResource($this->institution),
            'address' => $this->address,
            'phone' => $this->phone,
            'gpa' => $this->gpa,
            'semester' => $this->semester,
            'cv' => $this->cv,
            'transcript' => $this->transcript,
            'portfolio' => $this->portfolio
        ];
    }
}
