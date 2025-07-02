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
            'id' => $this->category_id,
            'name' => $this->category_name,
            'description' => $this->description,
            'image_url' => $this->getImage(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courses_count' => $this->courses()->count(),
        ];
    }
}
