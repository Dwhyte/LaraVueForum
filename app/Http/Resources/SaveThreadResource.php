<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class SaveThreadResource extends JsonResource
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
            'user_id' => $this->user_id,
            'thread_id' => $this->thread_id,
            'meta' => [
              'user' => new UserResource($this->Thread->User),  
              'slug' => $this->Thread->slug,
              'title' => $this->Thread->title,
              'skimmed_content' => Str::limit($this->Thread->content, 75, '...'), // show 75 characters only
              'category' => [
                'id' => $this->Thread->Category->id,
                'name' => $this->Thread->Category->name,
                'color' => $this->Thread->Category->color
              ]  
            ],
            'bookmarked' => $this->created_at->diffForHumans()
        ];
    }
}
