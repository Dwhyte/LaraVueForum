<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Mtownsend\ReadTime\ReadTime;

class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $time = Carbon::now()->subHour(24);
        $thread_date = Carbon::parse($this->created_at);

        // check if thread date is more than 24 hours old. set $is_thread_new to false.
        $is_thread_new = $thread_date <= $time ? false : true;

        $skimmed_content = Str::limit($this->content, 35, '...'); // show 35 characters only
        $read_time = (new ReadTime($this->content))->get();

        return [
            'id' => $this->id,
            'user' => $this->User->username,
            'user_id' => $this->User->id,
            'category' => $this->Category->name,
            'category_color' => $this->Category->color,
            'title' => $this->title,
            'slug' => $this->slug,
            'skimmed_content' => $skimmed_content,
            'read_time' => $read_time,
            'likes' => $this->Likes->count(),
            'replies' => $this->Replies->count(),
            "isNew" => $is_thread_new,
            'thread_created_on' => Carbon::parse($this->created_at)->format('M d'),
            'thread_updated_on' => $this->updated_at->diffForHumans()
        ];
    }
}
