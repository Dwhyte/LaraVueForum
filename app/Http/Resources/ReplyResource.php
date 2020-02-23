<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $avatar = $this->User->avatar ? ''.env('CLOUDINARY_FULL_AVATAR_PATH').''.$this->User->avatar .'' : null;

        return [
            'id' => $this->id,
            'reply' => $this->body,
            'user' => $this->User->username,
            'user_id' => $this->User->id,
            'user_avatar' => $avatar,
            'thread_slug' => $this->Thread->slug,
            'like_count' => $this->Likes->count(),
            'Liked' => !!$this->Likes->where('user_id', auth()->id())->count(),
            'replies' => ReplyResource::collection($this->Comments),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
