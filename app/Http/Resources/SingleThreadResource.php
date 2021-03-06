<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Mtownsend\ReadTime\ReadTime;

class SingleThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $read_time = (new ReadTime($this->content))->get();
        $featured_image = $this->featured_image ? ''.env('CLOUDINARY_FULL_FEATURED_IMAGE_PATH').''.$this->featured_image .'' : null;
        $category = [
            'id' => $this->Category->id,
            'name' => $this->Category->name,
            'color' => $this->Category->color
        ];

        return [
            'id' => $this->id,
            'user' => new UserResource($this->User),
            'category' => $category,
            'read_time' => $read_time,
            'title' => $this->title,
            'slug' => $this->slug,
            'featured_image' => $featured_image,
            'content' => $this->content,
            'like_count' => $this->Likes->count(),
            'reply_count' => $this->Replies->count(),
            'replies' => ReplyResource::collection($this->Replies),
            'thread_created_on' => Carbon::parse($this->created_at)->format('M d'),
            'thread_updated_on' => $this->updated_at->diffForHumans()
        ];
    }
}
