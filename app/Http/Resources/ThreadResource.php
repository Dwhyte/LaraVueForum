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

        $skimmed_content = Str::limit($this->content, 75, '...'); // show 75 characters only
        $read_time = (new ReadTime($this->content))->get();

        // dd($this->Category);
        // exit();

        return [
            'id' => $this->id,
            'user' => new UserResource($this->User),
            'category' => $this->Category->name,
            'category_color' => $this->Category->color,
            'title' => $this->title,
            'slug' => $this->slug,
            'skimmed_content' => $skimmed_content,
            'read_time' => $read_time,
            'likes' => $this->Likes->count(),
            'replies' => $this->Replies->count(),
            "isNew" => $is_thread_new,
            "created_at" => Carbon::parse($this->created_at)->format('d.m.y H:i:s'),
            'thread_created_on' => Carbon::parse($this->created_at)->format('M d'),
            'thread_updated_on' => $this->updated_at->diffForHumans()
        ];
    }
}
