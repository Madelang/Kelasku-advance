<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo !== null ? asset('storage/'. $this->photo) : null,
            "total_likes" => $this->total_likes,
            "created_at" => $this->created_at->format('Y-m-d H:m:s'),
            "school" => [
                "id" => $this->school->id,
                "school_name" => $this->school->school_name,
            ],
        ];
    }
}
