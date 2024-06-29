<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
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
            "photo" => $this->photo !== null ? asset($this->photo) : null,
            "total_likes" => $this->total_likes,
            "like_by_you" => Like::where('user_id', auth('api')->id())->where('like_user_id', $this->id)->count() === 1 ? true : false,
            "school" => [
                "id" => $this->school->id,
                "school_name" => $this->school->school_name,
            ],
        ];
    }
}
