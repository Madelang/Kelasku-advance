<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeHistoryResource extends JsonResource
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
            "id" => $this->user->id,
            "name" => $this->user->name,
            "photo" => url($this->user->photo),
            "school" => new SchoolResource($this->user->school),
            "like_at" => $this->created_at->diffForHumans(),
        ];
    }
}
