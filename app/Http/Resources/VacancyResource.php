<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
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
            'company' => new CompanyResource($this->company),
            'name' => $this->name,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'location' => $this->location,
            'sector' => $this->sector,
            'type' => $this->type,
            'paid' => $this->paid,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end
        ];
    }
}
