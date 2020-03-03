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
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'reply' => $this->body,
            'user' => new UserResource($this->User),
            'thread_slug' => $this->Thread->slug,
            'like_count' => $this->Likes->count(),
            'Liked' => !!$this->Likes->where('user_id', auth()->id())->count(),
            'replies' => ReplyResource::collection($this->Comments),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
