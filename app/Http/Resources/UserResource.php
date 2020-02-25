<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $avatar = $this->avatar ? ''.env('CLOUDINARY_FULL_AVATAR_PATH').''.$this->avatar .'' : null;

        return [
            'id' => $this->id,
            'username' => $this->username,
            'color' => $this->rand_color,
            'avatar' => $avatar
        ];
    }
}
