<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadResource;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getAllThreads', 'getSingleThread']]);
    }



    public function getAllThreads($category)
    {
        try {
            $threads = Thread::with(['User', 'Category', 'Replies', 'Likes'])
                ->orWhere('cat_id', $category)
                ->where('isDraft', 0)
                ->latest()
                ->paginate(15);

            return ThreadResource::collection($threads);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'msg' => 'No Threads.'], 404);
        }
    }
}
