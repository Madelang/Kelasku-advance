<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendDetailResource extends JsonResource
{

    private function formatPhoneNumber($phoneNumber)
    {
        $formattedPhoneNumber = preg_replace('/\D/', '', $phoneNumber);
        return strlen($formattedPhoneNumber) > 0 ? '62' . ltrim($formattedPhoneNumber, '0') : null;
    }


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
            "photo" => $this->photo !== null ? asset($this->photo) : null,
            "redirect_to_whatsapp" => "https://api.whatsapp.com/send?phone=" . $this->formatPhoneNumber($this->phone),
            "phone" => $this->phone,
            "banner_photo" => $this->banner_photo !== null ? asset($this->banner_photo) : null,
            "total_likes" => $this->total_likes,
            "like_by_you" => Like::where('user_id', auth('api')->id())->where('like_user_id', $this->id)->count() === 1 ? true : false,
            "created_at" => $this->created_at->format('Y-m-d H:m:s'),
            "school" => [
                "id" => $this->school->id,
                "school_name" => $this->school->school_name,
            ],
        ];
    }
}
